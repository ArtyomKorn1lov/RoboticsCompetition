<?php

namespace Robot\Core\Services\Program;

use Bitrix\Main\Type\DateTime;
use Robot\Core\DTO\Program\ProgramItems;
use Robot\Core\DTO\Program\ProgramCollection;

interface IProgramManager
{
    /**
     * @param int $eventId
     * @return ProgramItems
     */
    public function getProgram(int $eventId): ProgramItems;

    /**
     * @param DateTime $date
     * @param array|bool $sectionIds
     * @return ProgramCollection
     */
    public function getProgramList(DateTime $date, array|bool $sectionIds): ProgramCollection;
}