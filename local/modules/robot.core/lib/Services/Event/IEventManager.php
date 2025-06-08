<?php

namespace Robot\Core\Services\Event;

use Robot\Core\DTO\Event\FormField;
use Robot\Core\DTO\Event\RegisterForm;

interface IEventManager
{
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