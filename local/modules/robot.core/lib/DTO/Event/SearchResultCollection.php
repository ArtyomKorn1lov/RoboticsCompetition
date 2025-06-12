<?php

namespace Robot\Core\DTO\Event;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса SearchResult
 * @implements Collection<SearchResult>
 */
final class SearchResultCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return SearchResult::class;
    }
}