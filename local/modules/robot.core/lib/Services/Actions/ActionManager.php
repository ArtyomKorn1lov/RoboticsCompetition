<?php

namespace Robot\Core\Services\Actions;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\ArgumentException;

use Robot\Core\Constants;
use Robot\Core\Repositories\Actions\ActionRepository;
use Robot\Core\Tools\IBlocks\Helper;
use Robot\Core\Entity\Action\ActionItemsReqParams;
use Robot\Core\Tools\Mappers\Action;
use Robot\Core\DTO\Action\Action as ActionModel;
use Robot\Core\Entity\Action\ActionSectionsReqParams;

Loc::loadMessages(__FILE__);

class ActionManager implements IActionManager
{
    /**
     * @param int $id
     * @return ActionModel[]
     * @throws ArgumentException
     * @throws SystemException
     */
    public function getByEventId(int $id): array
    {
        try {
            if (empty($id)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_ERROR_EVENT_ID"));
            }

            $iblockId = Helper::getIblock(Constants::ACTIONS_IBLOCK_CODE);

            $entity = new ActionSectionsReqParams(
                Constants::CONTENT_IBLOCK_TYPE,
                $iblockId,
                $id,
                true,
                "DESC"
            );
            // TODO получать через сервис-локатор
            $actionRepository = new ActionRepository();
            $arSectionsIds = $actionRepository->getSectionsByEventId($entity);
            
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
            $response = $actionRepository->getActionsBySectionsIds($entity);

            if (empty($response)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ERROR_ACTIONS_EMPTY"));
            }
            
            /** @var ActionModel[] $items */
            $items = Action::mapActionsResponseToModel($response);

            return $items;
        } catch (SystemException|ArgumentException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }
}