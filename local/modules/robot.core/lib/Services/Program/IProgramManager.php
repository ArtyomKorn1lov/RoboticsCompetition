<?php

namespace Robot\Core\Services\Program;

use Bitrix\Main\Type\DateTime;
use Robot\Core\DTO\Program\ProgramItems;

interface IProgramManager
{
    public function getProgram(int $eventId): ProgramItems;

    public function getProgramByDate(DateTime $date, array|bool $sectionIds): array;
}