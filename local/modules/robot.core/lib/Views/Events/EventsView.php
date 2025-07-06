<?php

namespace Robot\Core\Views\Events;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\DTO\Action\ActionCollection;
use Robot\Core\DTO\Event\FormFieldCollection;
use Robot\Core\Services\Actions\IActionManager;
use Robot\Core\Services\Event\IEventManager;

Loc::loadMessages(__FILE__);

class EventsView
{
    /**
     * @return bool
     * @throws NotFoundExceptionInterface
     */
    public static function showRegistration(): bool
    {
        try {
            /** @var IEventManager $eventManager */
            $eventManager = ServiceLocator::getInstance()->get(IEventManager::class);
            $event = $eventManager->getActiveEvent();
            return $event->isRegister && $eventManager->isDateAvailable($event->expirationDate);
        } catch (SystemException $exception) {
            ShowError($exception->getMessage());
            return false;
        }
    }

    /**
     * @return bool
     * @throws NotFoundExceptionInterface
     */
    public static function showProgram(): bool
    {
        try {
            /** @var IEventManager $eventManager */
            $eventManager = ServiceLocator::getInstance()->get(IEventManager::class);
            $event = $eventManager->getActiveEvent();
            return $eventManager->isDateAvailable($event->expirationDate);
        } catch (SystemException $exception) {
            ShowError($exception->getMessage());
            return false;
        }
    }

    /**
     * @return int|bool
     */
    public static function getActiveEventId(): int|bool
    {
        try {
            /** @var IEventManager $eventManager */
            $eventManager = ServiceLocator::getInstance()->get(IEventManager::class);
            $event = $eventManager->getActiveEvent();
            return $event->id;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            ShowError($exception->getMessage());
            return false;
        }
    }

    /**
     * @return ActionCollection|bool
     */
    public static function getEventActions(): ActionCollection|bool
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
            ShowError($exception->getMessage());
            return false;
        }
    }

    /**
     * @return FormFieldCollection|bool
     */
    public static function getRegistrationFormFields(): FormFieldCollection|bool
    {
        try {
            /** @var IEventManager $eventManager */
            $eventManager = ServiceLocator::getInstance()->get(IEventManager::class);
            $fields = $eventManager->getRegistrationFields();

            if (empty($fields) || $fields->count() <= 0) {
                throw new SystemException("Ошибка получения полей формы");
            }

            return $fields;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            ShowError($exception->getMessage());
            return false;
        }
    }
}