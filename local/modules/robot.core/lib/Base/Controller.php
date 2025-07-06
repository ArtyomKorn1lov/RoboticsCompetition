<?php

namespace Robot\Core\Base;

use Bitrix\Main\Engine\Controller as MainController;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;

/**
 * Базовый котроллер
 * @implements MainController
 */
abstract class Controller extends MainController
{
    /**
     * @param string $message
     * @return AjaxJson
     */
    protected function onError(string $message): AjaxJson
    {
        $errorCollection = new ErrorCollection();
        $errorCollection->setError(new Error($message));
        return AjaxJson::createError($errorCollection);
    }
}