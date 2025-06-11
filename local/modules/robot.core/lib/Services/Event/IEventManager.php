<?php

namespace Robot\Core\Services\Event;

use Bitrix\Main\Type\DateTime;
use Robot\Core\DTO\Event\ActiveEvent;
use Robot\Core\DTO\Event\FormField;
use Robot\Core\DTO\Event\RegisterForm;

interface IEventManager
{
    /**
     * @return ActiveEvent
     */
    public function getActiveEvent(): ActiveEvent;

    /**
     * @param DateTime $date
     * @return bool
     */
    public function isDateAvailable(DateTime $date): bool;

    /**
     * @param RegisterForm $registerForm
     * @param int $eventId
     * @return void
     */
    public function saveForm(RegisterForm $registerForm, int $eventId): void;

    /**
     * @return FormField[]
     */
    public function getRegistrationFields(): array;
}