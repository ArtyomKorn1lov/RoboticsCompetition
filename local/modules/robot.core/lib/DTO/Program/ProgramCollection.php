<?php

namespace Robot\Core\DTO\Program;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса Program
 * @implements Collection<Program>
 */
final class ProgramCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Program::class;
    }
}