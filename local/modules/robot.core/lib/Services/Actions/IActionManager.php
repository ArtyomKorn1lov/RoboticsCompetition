<?php

namespace Robot\Core\Services\Actions;

use Robot\Core\DTO\Action as ActionModel;

interface IActionManager
{
    /**
     * @param int $id
     * @return ActionModel[]
     */
    public function getByEventId(int $id): array;
}