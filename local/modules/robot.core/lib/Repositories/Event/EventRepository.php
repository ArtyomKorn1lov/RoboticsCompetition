<?php

namespace Robot\Core\Repositories\Event;

use Bitrix\Main\ObjectException;
use CIBlockElement;

use Robot\Core\Entity\Event\RegisterForm;

class EventRepository
{
    public function saveForm(RegisterForm $registerFormEntity): void
    {
        try {
            $entity = new CIBlockElement();

            if (!$entity->Add($registerFormEntity->getFormData())) {
                throw new ObjectException($entity->LAST_ERROR);
            }
        } catch (ObjectException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }
}