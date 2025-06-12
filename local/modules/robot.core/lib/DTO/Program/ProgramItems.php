<?php

namespace Robot\Core\DTO\Program;

use Robot\Core\Constants;

final class ProgramItems
{
    /**
     * @param string $title
     * @param DateCollection|array $dates
     * @param ProgramCollection|array $programs
     * @param string $templateId
     * @param string $lang
     */
    public function __construct(
        public string            $title,
        public DateCollection|array    $dates,
        public ProgramCollection|array $programs,
        public string            $templateId = "",
        public string            $lang = Constants::LANG_RUSSIA_CODE
    )
    {
    }
}