<?php

namespace Robot\Core\DTO\Event;

class SearchResult
{
    /**
     * @param string $value
     */
    public function __construct(
        public string $value
    )
    {
    }
}