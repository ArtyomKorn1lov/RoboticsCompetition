<?php

namespace Robot\Core\Views\Program;

use Robot\Core\DTO\Program\ProgramItems;

interface IProgramView
{
    /**
     * @return ProgramItems
     */
    public static function getPrograms(): ProgramItems|bool;
}