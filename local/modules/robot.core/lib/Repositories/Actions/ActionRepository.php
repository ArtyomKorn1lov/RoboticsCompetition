<?php

namespace Robot\Core\Repositories\Actions;

use CIBlockSection;
use CIBlockElement;

use Robot\Core\Entity\Action\ActionSectionsReqParams;
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
            arOrder: $entity->getSortValues(),
            arFilter: $entity->getFilterValues(),
            arSelect: $entity->getSelectedFields()
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
            arOrder: $entity->getSortValues(),
            arFilter: $entity->getFilterValues(),
            arSelectFields: $entity->getSelectedFields()
        );

        $items = [];
        while ($arItem = $rsObject->fetch()) {
            $items[] = $arItem;
        }

        return $items;
    }
}