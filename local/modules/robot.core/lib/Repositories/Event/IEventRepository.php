<?php

namespace Robot\Core\Repositories\Event;

use Robot\Core\Entity\Event\ActiveEventReqParams;
use Robot\Core\Entity\Event\EventDetailReqParams;
use Robot\Core\Entity\Event\FormFieldCollection;
use Robot\Core\Entity\Event\RegisterForm;

interface IEventRepository
{
    /**
     * @param ActiveEventReqParams $apiParams
     * @return array
     */
    public function getActiveEvent(ActiveEventReqParams $apiParams): array;

    /**
     * @param RegisterForm $registerFormEntity
     * @return int
     */
    public function saveRegisterForm(RegisterForm $registerFormEntity): int;

    /**
     * @return int
     */
    public function getLastElementId(): int;

    /**
     * @param bool $isInit
     * @return FormFieldCollection
     */
    public function getRegistrationFields(bool $isInit): FormFieldCollection;

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