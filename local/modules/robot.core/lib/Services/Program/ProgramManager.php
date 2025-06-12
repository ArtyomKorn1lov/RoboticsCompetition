<?php

namespace Robot\Core\Services\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;
use Robot\Core\Constants;
use Robot\Core\DTO\Program\ProgramCollection;
use Robot\Core\DTO\Program\ProgramItems;
use Robot\Core\Entity\Program\ProgramListReqParam;
use Robot\Core\Entity\Program\ProgramSectionsReqParams;
use Robot\Core\Entity\Program\TimeLineReqParams;
use Robot\Core\Repositories\Program\IProgramRepository;
use Robot\Core\Tools\IBlocks\Helper;
use Robot\Core\Tools\Mappers\Program;
use Robot\Core\Views\Events\EventsView;

Loc::loadMessages(__FILE__);

class ProgramManager implements IProgramManager
{
    /** @var IProgramRepository репозиторий программа проведения события */
    private IProgramRepository $programRepository;

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $this->programRepository = ServiceLocator::getInstance()->get(IProgramRepository::class);
    }

    /**
     * @param int $eventId
     * @return ProgramItems
     * @throws ArgumentException
     * @throws ObjectException
     * @throws SystemException
     */
    public function getProgram(int $eventId): ProgramItems
    {
        try {
            if (empty($eventId)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_PROGRAM_INVALID_EVENT_ID"));
            }

            [$sectionIds, $sectionName] = $this->getProgramSections($eventId);
            if (empty($sectionIds)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_PROGRAM_EMPTY_SECTIONS"));
            }

            $timeLineEntity = new TimeLineReqParams(
                Constants::CONTENT_IBLOCK_TYPE,
                Helper::getIBlock(Constants::PROGRAM_IBLOCK_CODE),
                $sectionIds,
                true,
                "ASC"
            );
            $dateCollectionEntity = $this->programRepository->getTimeLine($timeLineEntity);
            $dateCollectionEntity->compareUnicDates();

            $programList = $this->getProgramByDate($dateCollectionEntity->offsetGet(0)->getDate(), $sectionIds);
            $dateList = Program::mapDateCollectionToModels($dateCollectionEntity);

            return new ProgramItems(
                title: $sectionName,
                dates: $dateList,
                programs: $programList,
                lang: Loc::getCurrentLang()
            );
        } catch (SystemException|ArgumentException|ObjectException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }

    /**
     * @param DateTime $date
     * @param array|bool $sectionIds
     * @return ProgramCollection
     * @throws ArgumentException
     * @throws SystemException
     */
    public function getProgramByDate(DateTime $date, array|bool $sectionIds = false): ProgramCollection
    {
        try {
            if (empty($date)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_PROGRAM_EMPTY_FILTER_DATE"));
            }

            if (!$sectionIds) {
                $eventId = EventsView::getActiveEventId();
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
        } catch (SystemException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }

    /**
     * @param int $eventId
     * @return array
     * @throws ArgumentException
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