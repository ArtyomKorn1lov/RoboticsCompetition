<?php

namespace Robot\Core\DTO\Event;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса FormField
 * @implements Collection<FormField>
 */
final class FormFieldCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return FormField::class;
    }
}