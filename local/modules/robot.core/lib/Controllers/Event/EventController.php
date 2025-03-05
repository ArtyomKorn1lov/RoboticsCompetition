<?php

namespace Robot\Core\Controllers\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
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
        } catch (SystemException|ArgumentException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            $errorCollection = new ErrorCollection();
            $errorCollection->setError(new Error($exception->getMessage()));
            return AjaxJson::createError($errorCollection);
        }
    }
}