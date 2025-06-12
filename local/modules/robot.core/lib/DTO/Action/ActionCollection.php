<?php

namespace Robot\Core\DTO\Action;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса Action
 * @implements Collection<Action>
 */
final class ActionCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Action::class;
    }
}