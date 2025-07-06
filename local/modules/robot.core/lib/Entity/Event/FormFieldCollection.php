<?php

namespace Robot\Core\Entity\Event;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса FormField
 * @implements Collection<FormField>
 */
class FormFieldCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return FormField::class;
    }
}