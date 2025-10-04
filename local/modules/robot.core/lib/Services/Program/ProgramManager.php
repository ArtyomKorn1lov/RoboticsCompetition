<?php

namespace Robot\Core\Services\Program;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;
use Robot\Core\Cache\ICacheService;
use Robot\Core\Constants;
use Robot\Core\DTO\Program\ProgramCollection;
use Robot\Core\DTO\Program\ProgramItems;
use Robot\Core\Entity\Program\ProgramListReqParam;
use Robot\Core\Entity\Program\ProgramSectionsReqParams;
use Robot\Core\Entity\Program\TimeLineReqParams;
use Robot\Core\Exceptions\RobotException;
use Robot\Core\Logger\Logger;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Repositories\Program\IProgramRepository;
use Robot\Core\Services\Event\IEventManager;
use Robot\Core\Tools\IBlocks\Helper;
use Robot\Core\Tools\Mappers\Program;

Loc::loadMessages(__FILE__);

class ProgramManager implements IProgramManager
{
    /** @var IProgramRepository репозиторий программа проведения события */
    private IProgramRepository $programRepository;
    /** @var ICacheService сервис кэширования */
    private ICacheService $cacheService;
    /** @var IEventManager сервис события */
    private IEventManager $eventManager;
    /** @var Logger объект логирования */
    private Logger $logger;

    /** @var string уникальный ключ кэша */
    protected const PROGRAM_CACHE_KEY = 'robot_core_cache_program_key';
    /** @var string путь к кэшу */
    protected const PROGRAM_CACHE_PATH = 'program/items';

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $serviceLocator = ServiceLocator::getInstance();
        $this->programRepository = $serviceLocator->get(IProgramRepository::class);
        $this->cacheService = $serviceLocator->get(ICacheService::class);
        $this->eventManager = $serviceLocator->get(IEventManager::class);
        $this->logger = LoggerFactory::build();
    }

    /**
     * @param int $eventId
     * @return ProgramItems
     * @throws RobotException
     * @throws SystemException
     */
    public function getProgram(int $eventId): ProgramItems
    {
        try {
            if (empty($eventId)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_PROGRAM_INVALID_EVENT_ID"));
            }

            if ($this->cacheService->init(self::PROGRAM_CACHE_KEY, self::PROGRAM_CACHE_PATH)) {
                /** @var ProgramItems $programItems */
                $programItems = $this->cacheService->getData();
                return $programItems;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::PROGRAM_CACHE_PATH);

                [$sectionIds, $sectionName] = $this->getProgramSections($eventId);
                if (empty($sectionIds)) {
                    throw new RobotException(Loc::getMessage("ROBOT_CORE_PROGRAM_EMPTY_SECTIONS"));
                }

                $programIblockId = Helper::getIBlock(Constants::PROGRAM_IBLOCK_CODE);
                $timeLineEntity = new TimeLineReqParams(
                    Constants::CONTENT_IBLOCK_TYPE,
                    $programIblockId,
                    $sectionIds,
                    true,
                    "ASC"
                );
                $dateCollectionEntity = $this->programRepository->getTimeLine($timeLineEntity);
                $dateCollectionEntity->compareUnicDates();

                $programList = $this->getProgramByDate($dateCollectionEntity->offsetGet(0)->getDate(), $sectionIds);
                $dateList = Program::mapDateCollectionToModels($dateCollectionEntity);

                $programItems = new ProgramItems(
                    title: $sectionName,
                    dates: $dateList,
                    programs: $programList,
                    lang: Loc::getCurrentLang()
                );

                $eventIblockId = Helper::getIBlock(Constants::EVENTS_IBLOCK_CODE);
                $this->cacheService->registerTag("iblock_id_$programIblockId");
                $this->cacheService->registerTag("iblock_id_$eventIblockId");
                $this->cacheService->endTag();
                $this->cacheService->end($programItems);
                return $programItems;
            } else {
                throw new SystemException("Ошибка создания кэша " . self::PROGRAM_CACHE_PATH);
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

    public function getProgramList(DateTime $date, array|bool $sectionIds = false): ProgramCollection
    {
        try {
            if ($this->cacheService->init(self::PROGRAM_CACHE_KEY, self::PROGRAM_CACHE_PATH, cacheParams: [$date->format('Y-m-d')])) {
                /** @var ProgramCollection $programList */
                $programList = $this->cacheService->getData();
                return $programList;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::PROGRAM_CACHE_PATH);

                $programList = $this->getProgramByDate($date, $sectionIds);

                $programIblockId = Helper::getIBlock(Constants::PROGRAM_IBLOCK_CODE);
                $eventIblockId = Helper::getIBlock(Constants::EVENTS_IBLOCK_CODE);

                $this->cacheService->registerTag("iblock_id_$programIblockId");
                $this->cacheService->registerTag("iblock_id_$eventIblockId");
                $this->cacheService->endTag();
                $this->cacheService->end($programList);
                return $programList;
            } else {
                throw new SystemException("Ошибка создания кэша " . self::PROGRAM_CACHE_PATH);
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

    /**
     * @param DateTime $date
     * @param array|bool $sectionIds
     * @return ProgramCollection
     * @throws RobotException
     */
    protected function getProgramByDate(DateTime $date, array|bool $sectionIds = false): ProgramCollection
    {
        if (empty($date)) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_PROGRAM_EMPTY_FILTER_DATE"));
        }

        if (!$sectionIds) {
            $eventId = $this->eventManager->getActiveEventElement()->id;
            [$sectionIds] = $this->getProgramSections($eventId);
        }

        $programListEntity = new ProgramListReqParam(
            iblockType: Constants::CONTENT_IBLOCK_TYPE,
            iblockId: Helper::getIBlock(Constants::PROGRAM_IBLOCK_CODE),
            sectionsIds: $sectionIds,
            date: $date,
            active: true,
            sort: "ASC"
        );
        $programCollectionEntity = $this->programRepository->getProgram($programListEntity);

        return Program::mapProgramCollectionToModels($programCollectionEntity);
    }

    /**
     * @param int $eventId
     * @return array
     * @throws RobotException
     */
    protected function getProgramSections(int $eventId): array
    {

        $programSectionEntity = new ProgramSectionsReqParams(
            iblockType: Constants::CONTENT_IBLOCK_TYPE,
            iblockId: Helper::getIBlock(Constants::PROGRAM_IBLOCK_CODE),
            eventId: $eventId,
            active: true,
            sort: "ASC"
        );
        return $this->programRepository->getActiveSectionIds($programSectionEntity);
    }
}