<?php

namespace Robot\Core\Controllers\Event;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;

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
            return AjaxJson::createSuccess("Успешно!");
        } catch (SystemException $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            $errorCollection = new ErrorCollection();
            $errorCollection->setError(new Error($exception->getMessage()));
            return AjaxJson::createError($errorCollection);
        }
    }
}