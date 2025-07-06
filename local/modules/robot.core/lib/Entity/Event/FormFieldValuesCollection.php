<?php

namespace Robot\Core\Entity\Event;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса FormFieldValues
 * @implements Collection<FormFieldValues>
 */
final class FormFieldValuesCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return FormFieldValues::class;
    }
}