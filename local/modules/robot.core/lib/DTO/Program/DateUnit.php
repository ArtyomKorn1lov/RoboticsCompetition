<?php

namespace Robot\Core\DTO\Program;

class DateUnit
{
    public function __construct(
        public string $date,
        public string $dateString
    )
    {
    }
}