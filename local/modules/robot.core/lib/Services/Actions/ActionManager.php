<?php

namespace Robot\Core\Services\Actions;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;
use Robot\Core\Cache\ICacheService;
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
    /** @var ICacheService сервис кэширования */
    private ICacheService $cacheService;
    /** @var Logger объект логирования */
    private Logger $logger;

    /** @var string уникальный ключ кэша */
    protected const ACTION_CACHE_KEY = 'robot_core_cache_action_key';
    /** @var string путь к кэшу */
    protected const ACTION_CACHE_PATH = 'actions/items';

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $serviceLocator = ServiceLocator::getInstance();
        $this->actionRepository = $serviceLocator->get(IActionRepository::class);
        $this->cacheService = $serviceLocator->get(ICacheService::class);
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

            if ($this->cacheService->init(self::ACTION_CACHE_KEY, self::ACTION_CACHE_PATH, cacheParams: [$id])) {
                /** @var ActionCollection $list */
                $list = $this->cacheService->getData();
                return $list;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::ACTION_CACHE_PATH);

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

                $list = Action::mapActionsResponseToCollection($response);

                $this->cacheService->registerTag("iblock_id_$iblockId");
                $this->cacheService->endTag();
                $this->cacheService->end($list);
                return $list;
            } else {
                throw new SystemException("Ошибка создания кэша " . self::ACTION_CACHE_PATH);
            }
        } catch (RobotException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            throw $exception;
        } catch (SystemException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            $this->logger->error($exception);
            throw $exception;
        }
    }
}