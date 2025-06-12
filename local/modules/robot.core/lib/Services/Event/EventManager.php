<?php

namespace Robot\Core\Services\Event;

use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\Constants;
use Robot\Core\Entity\Event\ActiveEventReqParams;
use Robot\Core\DTO\Event\ActiveEvent;
use Robot\Core\DTO\Event\AutocompleteSearch;
use Robot\Core\DTO\Event\RegisterExternalData;
use Robot\Core\DTO\Event\RegisterForm;
use Robot\Core\Entity\Event\RegisterForm as RegisterFormEntity;
use Robot\Core\Repositories\Event\IEventRepository;
use Robot\Core\Tools\Mappers\Event;
use Robot\Core\DTO\Event\FormFieldCollection;
use Robot\Core\Entity\Event\EventDetailReqParams;
use Robot\Core\DTO\Event\SearchResultCollection;
use Robot\Core\Tools\Mail\Helper as MailHelper;
use Robot\Core\Tools\Mail\IHelper as IMailHelper;
use Robot\Core\Tools\IBlocks\Helper as IBlockHelper;

Loc::loadMessages(__FILE__);

class EventManager implements IEventManager
{
    /** @var IEventRepository репозиторий события */
    private IEventRepository $eventRepository;

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $this->eventRepository = ServiceLocator::getInstance()->get(IEventRepository::class);
    }

    /**
     * @return ActiveEvent
     * @throws ArgumentException
     * @throws ObjectException
     * @throws SystemException
     */
    public function getActiveEvent(): ActiveEvent
    {
        try {
            $apiParams = new ActiveEventReqParams(
                iblockType: Constants::CONTENT_IBLOCK_TYPE,
                iblockId: IBlockHelper::getIBlock(Constants::EVENTS_IBLOCK_CODE),
                active: true
            );
            $item = $this->eventRepository->getActiveEvent($apiParams);

            if (empty($item)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENTS_GET_EMPTY"));
            }
            return Event::mapActiveEventResponseToModel($item);
        } catch (SystemException|ArgumentException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }

    /**
     * @param DateTime $date
     * @return bool
     */
    public function isDateAvailable(DateTime $date): bool
    {
        if ((new DateTime())->format("Y-m-d") > $date->format("Y-m-d")) {
            return false;
        }
        return true;
    }

    /**
     * @param RegisterForm $registerForm
     * @param int $eventId
     * @return void
     * @throws ArgumentException
     * @throws ObjectException
     * @throws SystemException
     */
    public function saveRegisterForm(RegisterForm $registerForm, int $eventId): void
    {
        try {
            if (empty($eventId)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ERROR_EVENT_ID"));
            }

            $lastElementId = $this->eventRepository->getLastElementId();
            $fields = $this->eventRepository->getRegistrationFields(false);

            if (empty($fields) || $fields->count() <= 0) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_EVENT_REGISTRATION_FIELDS_ERROR"));
            }

            $externalData = new RegisterExternalData(
                eventId: $eventId,
                lastElementId: $lastElementId
            );
            $entity = new RegisterFormEntity(
                fields: Event::mapFormFieldListEntityToModelList($fields),
                formData: $registerForm->formData,
                externalData: $externalData
            );
            $registrationId = $this->eventRepository->saveRegisterForm($entity);

            $this->sendMail($registerForm->formData, $eventId, $registrationId);
        } catch (SystemException|ArgumentException|ObjectException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }

    /**
     * @return FormFieldCollection
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getRegistrationFields(): FormFieldCollection
    {
        try {
            $fields = $this->eventRepository->getRegistrationFields();
            return Event::mapFormFieldListEntityToModelList($fields);
        } catch (SystemException|ArgumentException|ObjectException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }

    /**
     * @param AutocompleteSearch $autocompleteSearch
     * @return SearchResultCollection
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function searchAutocompleteValues(AutocompleteSearch $autocompleteSearch): SearchResultCollection
    {
        try {
            if (empty($autocompleteSearch->id)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENT_SEARCH_ERROR_ID"));
            }

            $entityName = $this->eventRepository->getFieldValueEntityById($autocompleteSearch->id);
            if (empty($entityName)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENT_ERROR_SEARCH_ENTITY"));
            }

            return Event::mapSearchResultArrayToModelList($this->eventRepository->searchAutocompleteValues($autocompleteSearch->value, $entityName));
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
            iblockType: Constants::CONTENT_IBLOCK_TYPE,
            iblockId: IBlockHelper::getIBlock(Constants::EVENTS_IBLOCK_CODE),
            id: $eventId,
            active: true
        );

        $mailModel = Event::mapEventRegistrationParamToMailModel(
            $formData,
            $this->eventRepository->getEventById($reqParams)["NAME"],
            $this->buildEditUrl(Constants::CONTENT_IBLOCK_TYPE, IBlockHelper::getIBlock(Constants::REGISTRATION_REQUEST_IBLOCK_CODE), $registrationId)
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

        /** @var IMailHelper $mailHelper */
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