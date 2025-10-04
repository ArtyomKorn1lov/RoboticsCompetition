<?php

namespace Robot\Core\Services\Event;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\Cache\ICacheService;
use Robot\Core\Constants;
use Robot\Core\Entity\Event\ActiveEventReqParams;
use Robot\Core\DTO\Event\ActiveEvent;
use Robot\Core\DTO\Event\AutocompleteSearch;
use Robot\Core\DTO\Event\RegisterExternalData;
use Robot\Core\DTO\Event\RegisterForm;
use Robot\Core\Entity\Event\RegisterForm as RegisterFormEntity;
use Robot\Core\Exceptions\RobotException;
use Robot\Core\Logger\Logger;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Repositories\Event\IEventRepository;
use Robot\Core\Tools\Mappers\Event;
use Robot\Core\DTO\Event\FormFieldCollection;
use Robot\Core\Entity\Event\EventDetailReqParams;
use Robot\Core\DTO\Event\SearchResultCollection;
use Robot\Core\Tools\Mail\Helper as MailHelper;
use Robot\Core\Tools\IBlocks\Helper as IBlockHelper;

Loc::loadMessages(__FILE__);

class EventManager implements IEventManager
{
    /** @var IEventRepository репозиторий события */
    private IEventRepository $eventRepository;
    /** @var ICacheService сервис кэширования */
    private ICacheService $cacheService;
    /** @var Logger объект логирования */
    private Logger $logger;

    /** @var string уникальный ключ кэша */
    protected const EVENT_CACHE_KEY = 'robot_core_cache_event_key';
    /** @var string путь к кэшу */
    protected const EVENT_CACHE_PATH = 'event/items';

    /** @var string уникальный ключ кэша */
    protected const REGISTRATION_FIELDS_CACHE_KEY = 'robot_core_registration_fields_key';
    /** @var string путь к кэшу */
    protected const REGISTRATION_FIELDS_CACHE_PATH = 'event/registration.fields';

    /** @var string уникальный ключ кэша */
    protected const COUNTRIES_CACHE_KEY = 'robot_core_countries_key';
    /** @var string путь к кэшу */
    protected const COUNTRIES_CACHE_PATH = 'event/countries';

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $serviceLocator = ServiceLocator::getInstance();
        $this->eventRepository = $serviceLocator->get(IEventRepository::class);
        $this->cacheService = $serviceLocator->get(ICacheService::class);
        $this->logger = LoggerFactory::build();
    }

    /**
     * @return ActiveEvent
     * @throws RobotException
     * @throws SystemException
     */
    public function getActiveEvent(): ActiveEvent
    {
        try {

            if ($this->cacheService->init(self::EVENT_CACHE_KEY, self::EVENT_CACHE_PATH)) {
                /** @var ActiveEvent $activeEvent */
                $activeEvent = $this->cacheService->getData();
                return $activeEvent;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::EVENT_CACHE_PATH);

                $eventIblockId = IBlockHelper::getIBlock(Constants::EVENTS_IBLOCK_CODE);

                $activeEvent = $this->getActiveEventElement();

                $this->cacheService->registerTag("iblock_id_$eventIblockId");
                $this->cacheService->endTag();
                $this->cacheService->end($activeEvent);
                return $activeEvent;
            } else {
                throw new SystemException("Ошибка создания кэша " . self::EVENT_CACHE_PATH);
            }
        } catch (RobotException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            throw $exception;
        } catch (SystemException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @return ActiveEvent
     * @throws RobotException
     * @throws ObjectException
     */
    public function getActiveEventElement(): ActiveEvent
    {
        $eventIblockId = IBlockHelper::getIBlock(Constants::EVENTS_IBLOCK_CODE);
        $apiParams = new ActiveEventReqParams(
            iblockType: Constants::CONTENT_IBLOCK_TYPE,
            iblockId: $eventIblockId,
            active: true
        );
        $item = $this->eventRepository->getActiveEvent($apiParams);
        if (empty($item)) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_EVENTS_GET_EMPTY"));
        }
        return Event::mapActiveEventResponseToModel($item);
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
     * @throws RobotException
     * @throws SystemException
     * @throws LoaderException
     */
    public function saveRegisterForm(RegisterForm $registerForm, int $eventId): void
    {
        try {
            if (!Loader::includeModule('iblock')) {
                throw new LoaderException("Модуль iblock не подключен");
            }

            if (empty($eventId)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_ERROR_EVENT_ID"));
            }

            $lastElementId = $this->eventRepository->getLastElementId();
            $fields = $this->eventRepository->getRegistrationFields(false);

            if (empty($fields) || $fields->count() <= 0) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_EVENT_REGISTRATION_FIELDS_ERROR"));
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
        } catch (RobotException $exception) {
            throw $exception;
        } catch (SystemException|LoaderException $exception) {
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @return FormFieldCollection
     * @throws SystemException
     * @throws RobotException
     */
    public function getRegistrationFields(): FormFieldCollection
    {
        try {
            if ($this->cacheService->init(self::REGISTRATION_FIELDS_CACHE_KEY, self::REGISTRATION_FIELDS_CACHE_PATH)) {
                /** @var FormFieldCollection $list */
                $list = $this->cacheService->getData();
                return $list;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::REGISTRATION_FIELDS_CACHE_PATH);

                $fields = $this->eventRepository->getRegistrationFields();
                $list = Event::mapFormFieldListEntityToModelList($fields);

                $this->cacheService->registerTag(Constants::REGISTRATION_FIELD_TAG_CACHE);
                $this->cacheService->endTag();
                $this->cacheService->end($list);
                return $list;
            } else {
                throw new SystemException("Ошибка создания кэша " . self::REGISTRATION_FIELDS_CACHE_PATH);
            }
        } catch (RobotException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            throw $exception;
        } catch (SystemException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @param AutocompleteSearch $autocompleteSearch
     * @return SearchResultCollection
     * @throws RobotException
     * @throws SystemException
     */
    public function searchAutocompleteValues(AutocompleteSearch $autocompleteSearch): SearchResultCollection
    {
        try {
            if ($this->cacheService->init(self::COUNTRIES_CACHE_KEY, self::COUNTRIES_CACHE_PATH, cacheParams: [$autocompleteSearch])) {
                /** @var SearchResultCollection $searchResult */
                $searchResult = $this->cacheService->getData();
                return $searchResult;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::COUNTRIES_CACHE_KEY);

                if (empty($autocompleteSearch->id)) {
                    throw new RobotException(Loc::getMessage("ROBOT_CORE_EVENT_SEARCH_ERROR_ID"));
                }
                $entityName = $this->eventRepository->getFieldValueEntityById($autocompleteSearch->id);
                if (empty($entityName)) {
                    throw new RobotException(Loc::getMessage("ROBOT_CORE_EVENT_ERROR_SEARCH_ENTITY"));
                }
                $searchResult = Event::mapSearchResultArrayToModelList($this->eventRepository->searchAutocompleteValues($autocompleteSearch->value, $entityName));

                $this->cacheService->registerTag(Constants::COUNTRIES_TAG_CACHE);
                $this->cacheService->endTag();
                $this->cacheService->end($searchResult);
                return $searchResult;
            } else {
                throw new SystemException("Ошибка создания кэша " . self::COUNTRIES_CACHE_PATH);
            }
        } catch (RobotException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            throw $exception;
        } catch (SystemException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @param array $formData
     * @param int $eventId
     * @param int $registrationId
     * @return void
     * @throws RobotException
     * @throws SystemException
     */
    protected function sendMail(array $formData, int $eventId, int $registrationId): void
    {
        if (empty($formData) || empty($eventId) || empty($registrationId)) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_EVENT_ARGUMENT_ERROR"));
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
     * @throws RobotException
     */
    protected function buildEditUrl(string $iblockType, int $iblockId, int $id): string
    {
        if (empty($iblockType) || empty($iblockId) || empty($id)) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_EVENT_ARGUMENT_ERROR"));
        }
        $url = Constants::EDIT_IBLOCK_ELEMENT_URL_TEMPLATE;
        $url = str_replace("#IBLOCK_TYPE#", $iblockType, $url);
        $url = str_replace("#IBLOCK_ID#", $iblockId, $url);
        return str_replace("#ID#", $id, $url);
    }
}