<?php

namespace Robot\Core\DTO\Program;

class Program
{
    public function __construct(
        public int $id,
        public string $name,
        public string $location,
        public string $timeLine,
    )
    {
    }
}