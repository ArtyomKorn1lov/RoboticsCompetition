<?php

namespace Robot\Core\DTO\Event;

final class AutocompleteSearch
{
    /**
     * @param int $id
     * @param string $value
     */
    public function __construct(
        public int $id,
        public string $value
    )
    {
    }
}