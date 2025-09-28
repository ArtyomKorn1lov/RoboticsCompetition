<?php

namespace Robot\Core\Services\Actions;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;
use Robot\Core\Constants;
use Robot\Core\DTO\Action\ActionCollection;
use Robot\Core\Exceptions\RobotException;
use Robot\Core\Logger\Logger;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Repositories\Actions\IActionRepository;
use Robot\Core\Tools\IBlocks\Helper;
use Robot\Core\Entity\Action\ActionItemsReqParams;
use Robot\Core\Tools\Mappers\Action;
use Robot\Core\Entity\Action\ActionSectionsReqParams;

Loc::loadMessages(__FILE__);

class ActionManager implements IActionManager
{
    /** @var IActionRepository репозиторий активных событий */
    private IActionRepository $actionRepository;
    /** @var Logger объект логирования */
    private Logger $logger;

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $serviceLocator = ServiceLocator::getInstance();
        $this->actionRepository = $serviceLocator->get(IActionRepository::class);
        $this->logger = LoggerFactory::build();
    }

    /**
     * @param int $id
     * @return ActionCollection
     * @throws SystemException
     * @throws RobotException
     */
    public function getByEventId(int $id): ActionCollection
    {
        try {
            if (empty($id)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_ERROR_EVENT_ID"));
            }

            $iblockId = Helper::getIBlock(Constants::ACTIONS_IBLOCK_CODE);

            $entity = new ActionSectionsReqParams(
                iblockType: Constants::CONTENT_IBLOCK_TYPE,
                iblockId: $iblockId,
                eventId: $id,
                active: true,
                sort: "DESC"
            );
            $arSectionsIds = $this->actionRepository->getSectionsByEventId($entity);
            
            if (empty($arSectionsIds)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_ERROR_ACTIONS_EMPTY"));
            }

            $entity = new ActionItemsReqParams(
                iblockType: Constants::CONTENT_IBLOCK_TYPE,
                iblockId: $iblockId,
                sectionsIds: $arSectionsIds,
                active: true,
                sort: "DESC"
            );
            $response = $this->actionRepository->getActionsBySectionsIds($entity);

            if (empty($response)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_ERROR_ACTIONS_EMPTY"));
            }

            return Action::mapActionsResponseToCollection($response);
        } catch (RobotException $exception) {
            throw $exception;
        } catch (SystemException $exception) {
            $this->logger->error($exception);
            throw $exception;
        }
    }
}