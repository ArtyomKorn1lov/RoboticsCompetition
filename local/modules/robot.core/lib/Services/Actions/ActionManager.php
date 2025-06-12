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
use Robot\Core\Repositories\Actions\IActionRepository;
use Robot\Core\Tools\IBlocks\Helper;
use Robot\Core\Entity\Action\ActionItemsReqParams;
use Robot\Core\Tools\Mappers\Action;
use Robot\Core\DTO\Action\Action as ActionModel;
use Robot\Core\Entity\Action\ActionSectionsReqParams;

Loc::loadMessages(__FILE__);

class ActionManager implements IActionManager
{
    /** @var IActionRepository репозиторий активных событий */
    private IActionRepository $actionRepository;

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $this->actionRepository = ServiceLocator::getInstance()->get(IActionRepository::class);
    }

    /**
     * @param int $id
     * @return ActionCollection
     * @throws ArgumentException
     * @throws SystemException
     */
    public function getByEventId(int $id): ActionCollection
    {
        try {
            if (empty($id)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_ERROR_EVENT_ID"));
            }

            $iblockId = Helper::getIBlock(Constants::ACTIONS_IBLOCK_CODE);

            $entity = new ActionSectionsReqParams(
                Constants::CONTENT_IBLOCK_TYPE,
                $iblockId,
                $id,
                true,
                "DESC"
            );
            $arSectionsIds = $this->actionRepository->getSectionsByEventId($entity);
            
            if (empty($arSectionsIds)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ERROR_ACTIONS_EMPTY"));
            }

            $entity = new ActionItemsReqParams(
                Constants::CONTENT_IBLOCK_TYPE,
                $iblockId,
                $arSectionsIds,
                true,
                "DESC"
            );
            $response = $this->actionRepository->getActionsBySectionsIds($entity);

            if (empty($response)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ERROR_ACTIONS_EMPTY"));
            }

            return Action::mapActionsResponseToCollection($response);
        } catch (SystemException|ArgumentException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }
}