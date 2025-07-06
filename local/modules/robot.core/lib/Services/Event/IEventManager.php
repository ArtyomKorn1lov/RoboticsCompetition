<?php

namespace Robot\Core\Services\Event;

use Bitrix\Main\Type\DateTime;
use Robot\Core\DTO\Event\ActiveEvent;
use Robot\Core\DTO\Event\FormFieldCollection;
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
    public function saveRegisterForm(RegisterForm $registerForm, int $eventId): void;

    /**
     * @return FormFieldCollection
     */
    public function getRegistrationFields(): FormFieldCollection;
}