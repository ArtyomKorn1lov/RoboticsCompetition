<?php

namespace Robot\Core\DTO\Program;

class ProgramItems
{
    /**
     * @param string $title
     * @param DateUnit[] $dates
     * @param Program[] $programs
     */
    public function __construct(
        public string $title,
        public array $dates,
        public array $programs,
        public string $templateId = ""
    )
    {
    }
}