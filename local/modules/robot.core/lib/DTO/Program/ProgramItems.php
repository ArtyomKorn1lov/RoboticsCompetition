<?php

namespace Robot\Core\DTO\Program;

use Robot\Core\Constants;

class ProgramItems
{
    /**
     * @param string $title
     * @param array $dates
     * @param array $programs
     * @param string $templateId
     * @param string $lang
     */
    public function __construct(
        public string $title,
        public array $dates,
        public array $programs,
        public string $templateId = "",
        public string $lang = Constants::LANG_RUSSIA_CODE
    )
    {
    }
}