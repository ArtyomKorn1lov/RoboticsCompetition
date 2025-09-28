<?php

namespace Robot\Core\Views\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\SystemException;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\Exceptions\RobotException;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Services\Program\IProgramManager;
use Robot\Core\Views\Events\EventsView;
use Robot\Core\DTO\Program\ProgramItems;

Loc::loadMessages(__FILE__);

class ProgramView
{

    /**
     * @return ProgramItems|bool
     */
    public static function getPrograms(): ProgramItems|bool
    {
        try {
            $eventId = EventsView::getActiveEventId();
            if (!$eventId) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_PROGRAM_INVALID_EVENT_ID"));
            }

            /** @var IProgramManager $programManager */
            $programManager = ServiceLocator::getInstance()->get(IProgramManager::class);
            return $programManager->getProgram($eventId);
        } catch (RobotException $exception) {
            ShowError($exception->getMessage());
            return false;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            LoggerFactory::build()->error($exception);
            ShowError("Произошла внутренняя ошибка");
            return false;
        }
    }
}