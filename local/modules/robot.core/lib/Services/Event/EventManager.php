<?php

namespace Robot\Core\Services\Event;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

use Robot\Core\DTO\Event\AutocompleteSearch;
use Robot\Core\DTO\Event\RegisterExternalData;
use Robot\Core\DTO\Event\RegisterForm;
use Robot\Core\Entity\Event\RegisterForm as RegisterFormEntity;
use Robot\Core\Repositories\Event\EventRepository;
use Robot\Core\Tools\Mappers\Event;
use Robot\Core\DTO\Event\FormField;

Loc::loadMessages(__FILE__);

class EventManager implements IEventManager
{
    /**
     * @param RegisterForm $registerForm
     * @param int $eventId
     * @return void
     * @throws ArgumentException
     * @throws ObjectException
     * @throws SystemException
     */
    public function saveForm(RegisterForm $registerForm, int $eventId): void
    {
        try {
            if (empty($eventId)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ERROR_EVENT_ID"));
            }

            // TODO вынести в сервис-локатор
            $eventRepository = new EventRepository();
            $lastElementId = $eventRepository->getLastElementId();
            $fields = $eventRepository->getRegistrationFields(false);

            if (empty($fields)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_EVENT_REGISTRATION_FIELDS_ERROR"));
            }

            $externalData = new RegisterExternalData(
                eventId: $eventId,
                lastElementId: $lastElementId
            );
            $entity = new RegisterFormEntity(
                Event::mapFormFieldListEntityToModelList($fields),
                $registerForm->formData,
                $externalData
            );
            $eventRepository->saveForm($entity);
        } catch (SystemException|ArgumentException|ObjectException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }

    /**
     * @return FormField[]
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getRegistrationFields(): array
    {
        try {
            // TODO вынести в сервис-локатор
            $eventRepository = new EventRepository();
            $fields = $eventRepository->getRegistrationFields();
            return Event::mapFormFieldListEntityToModelList($fields);
        } catch (SystemException|ArgumentException|ObjectException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }

    /**
     * @param AutocompleteSearch $autocompleteSearch
     * @return array
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws LoaderException
     */
    public function searchAutocompleteValues(AutocompleteSearch $autocompleteSearch): array
    {
        try {
            if (empty($autocompleteSearch->id)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENT_SEARCH_ERROR_ID"));
            }

            // TODO вынести в сервис-локатор
            $eventRepository = new EventRepository();
            $entityName = $eventRepository->getFieldValueEntityById($autocompleteSearch->id);
            if (empty($entityName)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENT_ERROR_SEARCH_ENTITY"));
            }

            return Event::mapSearchResultArrayToModelList($eventRepository->searchAutocompleteValues($autocompleteSearch->value, $entityName));
        } catch (SystemException|ArgumentException|ObjectException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }
}