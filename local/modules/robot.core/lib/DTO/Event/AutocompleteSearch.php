<?php

namespace Robot\Core\DTO\Event;

final class AutocompleteSearch
{
    public function __construct(
        public int $id,
        public string $value
    )
    {
    }
}