<?php

namespace Robot\Core\Controllers\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

use Robot\Core\DTO\Event\AutocompleteSearch;
use Robot\Core\Services\Event\EventManager;
use Robot\Core\Tools\Mappers\Event;
use Robot\Core\Views\Events\EventsView;

Loc::loadMessages(__FILE__);

class EventController extends Controller
{
    /**
     * @return array[]
     */
    public function configureActions(): array
    {
        return [
            "register" => [
                "prefilters" => []
            ],
            "countries" => [
                "prefilters" => []
            ]
        ];
    }

    /**
     * @param array $formData
     * @return AjaxJson
     */
    public function registerAction(array $formData): AjaxJson
    {
        try {
            if (empty($formData)) {
                throw new ArgumentException("Не заполненная форма регистрации");
            }

            $eventId = EventsView::getActiveEventId();
            if (!$eventId) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_PROGRAM_INVALID_EVENT_ID"));
            }

            // TODO вынести в сервис-локатор
            $eventManager = new EventManager();
            $eventManager->saveForm(Event::mapRegisterFormArrayToModel($formData), $eventId);

            return AjaxJson::createSuccess("Вы успешно зарегистрировались на текущее событие!");
        } catch (SystemException|ArgumentException|ObjectException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            $errorCollection = new ErrorCollection();
            $errorCollection->setError(new Error($exception->getMessage()));
            return AjaxJson::createError($errorCollection);
        }
    }

    /**
     * @param int $id
     * @param string $value
     * @return AjaxJson
     * @throws LoaderException
     */
    public function countriesAction(int $id, string $value = ""): AjaxJson
    {
        try {
            if (empty($id)) {
                throw new ArgumentException("Не указано id поля для поиска");
            }

            $autocompleteSearch = new AutocompleteSearch(
                id: $id,
                value: $value
            );
            // TODO вынести в сервис-локатор
            $eventManager = new EventManager();
            $result = $eventManager->searchAutocompleteValues($autocompleteSearch);

            return AjaxJson::createSuccess($result);
        } catch (SystemException|ArgumentException|ObjectException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            $errorCollection = new ErrorCollection();
            $errorCollection->setError(new Error($exception->getMessage()));
            return AjaxJson::createError($errorCollection);
        }
    }
}