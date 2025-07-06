<?php

namespace Robot\Core\Repositories\Actions;

use Robot\Core\Entity\Action\ActionItemsReqParams;
use Robot\Core\Entity\Action\ActionSectionsReqParams;

interface IActionRepository
{
    /**
     * @param ActionSectionsReqParams $entity
     * @return int[]
     */
    public function getSectionsByEventId(ActionSectionsReqParams $entity): array;

    /**
     * @param ActionItemsReqParams $entity
     * @return array
     */
    public function getActionsBySectionsIds(ActionItemsReqParams $entity): array;
}