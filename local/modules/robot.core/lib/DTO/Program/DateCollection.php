<?php

namespace Robot\Core\DTO\Program;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса DateUnit
 * @implements Collection<DateUnit>
 */
final class DateCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return DateUnit::class;
    }
}