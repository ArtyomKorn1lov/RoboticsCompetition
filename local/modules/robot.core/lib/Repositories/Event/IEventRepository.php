<?php

namespace Robot\Core\Repositories\Event;

use Robot\Core\Entity\Event\EventDetailReqParams;
use Robot\Core\Entity\Event\RegisterForm;
use Robot\Core\Entity\Event\FormField;

interface IEventRepository
{
    /**
     * @param RegisterForm $registerFormEntity
     * @return int
     */
    public function saveForm(RegisterForm $registerFormEntity): int;

    /**
     * @return int
     */
    public function getLastElementId(): int;

    /**
     * @param bool $isInit
     * @return FormField[]
     */
    public function getRegistrationFields(bool $isInit): array;

    /**
     * @param int $id
     * @return string
     */
    public function getFieldValueEntityById(int $id): string;

    /**
     * @param string $value
     * @param string $entityName
     * @return array
     */
    public function searchAutocompleteValues(string $value, string $entityName): array;

    /**
     * @param EventDetailReqParams $entity
     * @return array
     */
    public function getEventById(EventDetailReqParams $entity): array;
}