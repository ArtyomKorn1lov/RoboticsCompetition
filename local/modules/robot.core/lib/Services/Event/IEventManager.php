<?php

namespace Robot\Core\Services\Event;

use Robot\Core\DTO\Event\RegisterForm;

interface IEventManager
{
    public function saveForm(RegisterForm $registerForm, int $eventId): void;
}