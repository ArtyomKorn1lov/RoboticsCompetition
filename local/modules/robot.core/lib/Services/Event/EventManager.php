<?php

namespace Robot\Core\Services\Event;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Config\Option;

use Robot\Core\Constants;
use Robot\Core\DTO\Event\AutocompleteSearch;
use Robot\Core\DTO\Event\RegisterExternalData;
use Robot\Core\DTO\Event\RegisterForm;
use Robot\Core\Entity\Event\RegisterForm as RegisterFormEntity;
use Robot\Core\Repositories\Event\EventRepository;
use Robot\Core\Tools\Mappers\Event;
use Robot\Core\DTO\Event\FormField;
use Robot\Core\Entity\Event\EventDetailReqParams;
use Robot\Core\Tools\Mail\Helper as MailHelper;
use Robot\Core\Tools\IBlocks\Helper as IBlockHelper;

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
            $registrationId = $eventRepository->saveForm($entity);
            $this->sendMail($registerForm->formData, $eventId, $registrationId);
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

    /**
     * @param array $formData
     * @param int $eventId
     * @param int $registrationId
     * @return void
     * @throws ArgumentException
     * @throws SystemException
     */
    protected function sendMail(array $formData, int $eventId, int $registrationId): void
    {
        if (empty($formData) || empty($eventId) || empty($registrationId)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENT_ARGUMENT_ERROR"));
        }
        $reqParams = new EventDetailReqParams(
            Constants::CONTENT_IBLOCK_TYPE,
            IBlockHelper::getIBlock(Constants::EVENTS_IBLOCK_CODE),
            $eventId,
            true
        );

        // TODO вынести в сервис-локатор
        $eventRepository = new EventRepository();
        $mailModel = Event::mapEventRegistrationParamToMailModel(
            $formData,
            $eventRepository->getEventById($reqParams)["NAME"], $this->buildEditUrl(Constants::CONTENT_IBLOCK_TYPE, IBlockHelper::getIBlock(Constants::REGISTRATION_REQUEST_IBLOCK_CODE), $registrationId)
        );

        $arFields = [
            "EVENT_NAME" => $mailModel->eventName,
            "NAME" => $mailModel->name,
            "EMAIL" => $mailModel->email,
            "BIRTHDAY" => $mailModel->birthday,
            "COUNTRY" => $mailModel->country,
            "COURSE" => $mailModel->course,
            "CODE_AND_AREA_TRAINING" => $mailModel->codeAndAreaTraining,
            "PHONE" => $mailModel->phone,
            "PREVIEW_TEXT" => $mailModel->description,
            "EDIT_URL" => $mailModel->editUrl,
            "DEFAULT_RECIPIENT_EMAIL" => Option::get('robot.core', Constants::DEFAULT_RECIPIENT_EMAIL_OPTION_CODE)
        ];

        $mailHelper = new MailHelper(
            Constants::REGISTRATION_MAIL_EVENT_CODE,
            SITE_ID
        );
        $mailHelper->sendMail($arFields);
    }

    /**
     * @param string $iblockType
     * @param int $iblockId
     * @param int $id
     * @return string
     * @throws ArgumentException
     */
    protected function buildEditUrl(string $iblockType, int $iblockId, int $id): string
    {
        if (empty($iblockType) || empty($iblockId) || empty($id)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENT_ARGUMENT_ERROR"));
        }
        $url = Constants::EDIT_IBLOCK_ELEMENT_URL_TEMPLATE;
        $url = str_replace("#IBLOCK_TYPE#", $iblockType, $url);
        $url = str_replace("#IBLOCK_ID#", $iblockId, $url);
        return str_replace("#ID#", $id, $url);
    }
}