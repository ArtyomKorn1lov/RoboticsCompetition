<?php

namespace Robot\Core\Repositories\Actions;

use CIBlockSection;
use CIBlockElement;

use Robot\Core\Entity\Actions\ActionSectionsReqParams;
use Robot\Core\Entity\Action\ActionItemsReqParams;

class ActionRepository implements IActionRepository
{
    /**
     * @param ActionSectionsReqParams $entity
     * @return int[]
     */
    public function getSectionsByEventId(ActionSectionsReqParams $entity): array
    {
        $rsObject = CIBlockSection::GetList(
            $entity->getSortValues(),
            $entity->getFilterValues(),
            false,
            $entity->getSelectedFields()
        );

        $ids = [];
        while ($arSection = $rsObject->fetch()) {
            $ids[] = (int)$arSection["ID"];
        }

        return $ids;
    }

    /**
     * @param ActionItemsReqParams $entity
     * @return array
     */
    public function getActionsBySectionsIds(ActionItemsReqParams $entity): array
    {
        $rsObject = CIBlockElement::GetList(
            $entity->getSortValues(),
            $entity->getFilterValues(),
            false,
            false,
            $entity->getSelectedFields()
        );

        $items = [];
        while ($arItem = $rsObject->fetch()) {
            $items[] = $arItem;
        }

        return $items;
    }
}