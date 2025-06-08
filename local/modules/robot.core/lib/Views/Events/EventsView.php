<?php

namespace Robot\Core\Views\Events;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\DI\ServiceLocator;
use CIBlockElement;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\Constants;
use Robot\Core\DTO\Action\Action;
use Robot\Core\DTO\Event\ActiveEvent;
use Robot\Core\DTO\Event\FormField;
use Robot\Core\Entity\Event\ActiveEventReqParams;
use Robot\Core\Services\Actions\IActionManager;
use Robot\Core\Services\Event\IEventManager;
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
            return $event->isRegister && static::isDateAvailable($event->expirationDate);
        } catch (SystemException|LoaderException $exception) {
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
            return static::isDateAvailable($event->expirationDate);
        } catch (SystemException|LoaderException $exception) {
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
        } catch (SystemException|LoaderException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            return false;
        }
    }

    /**
     * @return Action[]|bool
     */
    public static function getEventActions(): array|bool
    {
        try {
            $id = static::getActiveEventId();
            if (!$id) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_EVENTS_GET_EMPTY"));
            }

            /** @var IActionManager $actionManager */
            $actionManager = ServiceLocator::getInstance()->get(IActionManager::class);

            return $actionManager->getByEventId($id);
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            return false;
        }
    }

    /**
     * @return FormField[]|bool
     */
    public static function getRegistrationFormFields(): array|bool
    {
        try {
            /** @var IEventManager $eventManager */
            $eventManager = ServiceLocator::getInstance()->get(IEventManager::class);
            $fields = $eventManager->getRegistrationFields();

            if (empty($fields)) {
                throw new SystemException("Ошибка получения полей формы");
            }

            return $fields;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
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
            Helper::getIBlock(Constants::EVENTS_IBLOCK_CODE),
            true
        );

        $rsObject = CIBlockElement::GetList($apiParams->getSortValues(), $apiParams->getFilterValues(), false, ["nTopCount" => 1], $apiParams->getSelectedFields());

        $item = $rsObject->fetch();
        if (!$item) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENTS_GET_EMPTY"));
        }

        return Event::mapActiveEventResponseToModel($item);
    }

    /**
     * @param DateTime $date
     * @return bool
     */
    protected static function isDateAvailable(DateTime $date): bool
    {
        $curDate = new DateTime();
        if ($curDate->format("Y-m-d") > $date->format("Y-m-d")) {
            return false;
        }
        return true;
    }
}