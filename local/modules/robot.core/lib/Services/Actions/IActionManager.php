<?php

namespace Robot\Core\Services\Actions;

use Robot\Core\DTO\Action\ActionCollection;

interface IActionManager
{
    /**
     * @param int $id
     * @return ActionCollection
     */
    public function getByEventId(int $id): ActionCollection;
}