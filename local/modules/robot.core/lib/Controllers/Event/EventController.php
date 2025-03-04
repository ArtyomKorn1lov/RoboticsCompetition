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

Loc::loadMessages(__FILE__);

class EventController extends Controller
{
    public function configureActions(): array
    {
        return [
            "register" => [
                "prefilters" => []
            ]
        ];
    }

    public function registerAction(array $formData): AjaxJson
    {
        try {
            if (empty($formData)) {
                throw new ArgumentException("Не заполненная форма регистрации");
            }

            // TODO вынести в сервис-локатор
            $eventManager = new EventManager();
            $eventManager->saveForm(Event::mapRegisterFormArrayToModel($formData));

            return AjaxJson::createSuccess("Вы успешно зарегистрировались на текущее событие!");
        } catch (SystemException|ArgumentException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            $errorCollection = new ErrorCollection();
            $errorCollection->setError(new Error($exception->getMessage()));
            return AjaxJson::createError($errorCollection);
        }
    }
}