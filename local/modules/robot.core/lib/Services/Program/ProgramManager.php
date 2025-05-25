<?php

namespace Robot\Core\Services\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;
use Robot\Core\Constants;
use Robot\Core\DTO\Program\ProgramItems;
use Robot\Core\Entity\Program\ProgramListReqParam;
use Robot\Core\Entity\Program\ProgramSectionsReqParams;
use Robot\Core\Entity\Program\TimeLineReqParams;
use Robot\Core\Repositories\Program\ProgramRepository;
use Robot\Core\Tools\IBlocks\Helper;
use Robot\Core\Tools\Mappers\Program;
use Robot\Core\Views\Events\EventsView;

Loc::loadMessages(__FILE__);

class ProgramManager implements IProgramManager
{

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
            if (!$eventId) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_PROGRAM_INVALID_EVENT_ID"));
            }

            // TODO вынести в сервис-локатор
            $programRepository = new ProgramRepository();

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
            $dateCollectionEntity = $programRepository->getTimeLine($timeLineEntity);

            $programList = $this->getProgramByDate($dateCollectionEntity->getDateUnicByIndex(0)->getDate(), $sectionIds);
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
     * @return array
     * @throws ArgumentException
     * @throws SystemException
     */
    public function getProgramByDate(DateTime $date, array|bool $sectionIds = false): array
    {
        try {
            if (empty($date)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_PROGRAM_EMPTY_FILTER_DATE"));
            }

            // TODO вынести в сервис-локатор
            $programRepository = new ProgramRepository();

            if (!$sectionIds) {
                $eventId = EventsView::getActiveEventId();
                [$sectionIds] = $this->getProgramSections($eventId);
            }

            $programListEntity = new ProgramListReqParam(
                Constants::CONTENT_IBLOCK_TYPE,
                Helper::getIBlock(Constants::PROGRAM_IBLOCK_CODE),
                $sectionIds,
                $date,
                true,
                "ASC"
            );
            $programCollectionEntity = $programRepository->getProgram($programListEntity);

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
        // TODO вынести в сервис-локатор
        $programRepository = new ProgramRepository();

        $programSectionEntity = new ProgramSectionsReqParams(
            Constants::CONTENT_IBLOCK_TYPE,
            Helper::getIBlock(Constants::PROGRAM_IBLOCK_CODE),
            $eventId,
            true,
            "ASC"
        );
        return $programRepository->getActiveSectionIds($programSectionEntity);
    }
}