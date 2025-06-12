<?php

namespace Robot\Core\DTO\Program;

final class Program
{
    /**
     * @param int $id
     * @param string $name
     * @param string $location
     * @param string $timeLine
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $location,
        public string $timeLine,
    )
    {
    }
}