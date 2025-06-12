<?php

namespace Robot\Core\DTO\Event;

final class SearchResult
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