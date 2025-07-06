<?php

namespace Robot\Core\Tools\Mappers;

use Robot\Core\DTO\Action\Action as ActionModel;
use Robot\Core\DTO\Action\ActionCollection;

class Action
{
    /**
     * @param array $response
     * @return ActionCollection
     */
    public static function mapActionsResponseToCollection(array $response): ActionCollection
    {
        $collection = new ActionCollection();
        foreach ($response as $item) {
            $collection->add(new ActionModel(
                id: $item["ID"],
                name: $item["NAME"],
                description: $item["DETAIL_TEXT"] ?? ""
            ));
        }
        return $collection;
    }
}