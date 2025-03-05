<?php

namespace Robot\Core\Repositories\Event;

use Robot\Core\Entity\Event\RegisterForm;

interface IEventRepository
{
    public function saveForm(RegisterForm $registerFormEntity): void;
}