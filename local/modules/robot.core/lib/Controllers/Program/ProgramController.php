<?php

namespace Robot\Core\Controllers\Program;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\Services\Program\IProgramManager;
use Robot\Core\Middleware\Language;

Loc::loadMessages(__FILE__);

class ProgramController extends Controller
{

    /**
     * @return array[]
     */
    public function configureActions(): array
    {
        return [
            "getItems" => [
                "prefilters" => [
                    new Language()
                ]
            ]
        ];
    }

    /**
     * @param string $date
     * @return AjaxJson
     */
    public function getItemsAction(string $date): AjaxJson
    {
        try {
            if (empty($date)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
            }

            /** @var IProgramManager $programManager */
            $programManager = ServiceLocator::getInstance()->get(IProgramManager::class);
            $programs = $programManager->getProgramByDate(new DateTime($date));

            return AjaxJson::createSuccess($programs);
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            AddMessage2Log($exception->getMessage(), "robot.core");
            $errorCollection = new ErrorCollection();
            $errorCollection->setError(new Error($exception->getMessage()));
            return AjaxJson::createError($errorCollection);
        }
    }
}