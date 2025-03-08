<?php

namespace Robot\Core\DTO\Event;

class SearchResult
{
    public function __construct(
        public string $value
    )
    {
    }
}