<?php

namespace Robot\Core\Controllers\Program;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\Services\Program\IProgramManager;
use Robot\Core\Middleware\Language;
use Robot\Core\Base\Controller;

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

            return AjaxJson::createSuccess($programs->mapToArray(fn($item) => $item));
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            return $this->onError($exception->getMessage());
        }
    }
}