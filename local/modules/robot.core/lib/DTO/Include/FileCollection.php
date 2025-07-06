<?php

namespace Robot\Core\DTO\Include;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса File
 * @implements Collection<File>
 */
final class FileCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return File::class;
    }
}