<?php

namespace Robot\Core\DTO\Program;

class DateUnit
{
    /**
     * @param string $date
     * @param string $dateString
     */
    public function __construct(
        public string $date,
        public string $dateString
    )
    {
    }
}