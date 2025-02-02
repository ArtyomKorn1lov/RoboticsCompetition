<?php

namespace Robot\Core\Views;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\Type\DateTime;
use CIBlockElement;

use Robot\Core\Constants;
use Robot\Core\DTO\Action;
use Robot\Core\DTO\ActiveEvent;
use Robot\Core\Entity\ActiveEventReqParams;
use Robot\Core\Services\Actions\ActionManager;
use Robot\Core\Tools\IBlocks\Helper;
use Robot\Core\Tools\Mappers\Event;
use Robot\Core\Tools\Modules\Manager;

Loc::loadMessages(__FILE__);

class EventsView implements IEventsView
{
    /** @var string[] Модули участвующие в работе класса */
    protected const MODULES_CODES = [
        "iblock"
    ];

    /**
     * @return bool
     */
    public static function showRegistration(): bool
    {
        try {
            Manager::requireModules(static::MODULES_CODES);
            $event = static::getActiveEvent();
            return $event->isRegister && static::isDateAvaliable($event->expirationDate);
        } catch (SystemException|LoaderException|ObjectException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            return false;
        }
    }

    /**
     * @return bool
     */
    public static function showProgram(): bool
    {
        try {
            static::requireModules();
            $event = static::getActiveEvent();
            return static::isDateAvaliable($event->expirationDate);
        } catch (SystemException|LoaderException|ObjectException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            return false;
        }
    }

    /**
     * @return int|bool
     */
    public static function getActiveEventId(): int|bool
    {
        try {
            static::requireModules();
            $event = static::getActiveEvent();
            return $event->id;
        } catch (SystemException|LoaderException|ObjectException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            return false;
        }
    }

    /**
     * @return array<Action>|bool
     */
    public static function getEventActions(): array|bool
    {
        try {
            $id = static::getActiveEventId();
            if (!$id) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_EVENTS_GET_EMPTY"));
            }

            // TODO получать через сервис-локатор
            $actionManager = new ActionManager();

            return $actionManager->getByEventId($id);
        } catch (SystemException|ObjectException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            return false;
        }
    }

    /**
     * @return void
     * @throws LoaderException
     */
    protected static function requireModules(): void
    {
        Manager::requireModules(static::MODULES_CODES);
    }

    /**
     * @return ActiveEvent
     * @throws ArgumentException|ObjectException
     */
    protected static function getActiveEvent(): ActiveEvent
    {
        $apiParams = new ActiveEventReqParams(
            Constants::CONTENT_IBLOCK_TYPE,
            Helper::getIblock(Constants::EVENTS_IBLOCK_CODE),
            true
        );

        $rsObject = CIBlockElement::GetList($apiParams->getSortValues(), $apiParams->getFilterValues(), false, ["nTopCount" => 1], $apiParams->getSelectedFields());

        $item = $rsObject->fetch();
        if (!$item) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENTS_GET_EMPTY"));
        }

        return Event::mapActiveEventResponseToModel($item);
    }

    protected static function isDateAvaliable(DateTime $date): bool
    {
        $curDate = new DateTime();
        if ($curDate->getTimestamp() > $date->getTimestamp()) {
            return false;
        }
        return true;
    }
}