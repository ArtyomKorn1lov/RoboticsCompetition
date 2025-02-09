<?php

namespace Robot\Core\Tools\Mappers;

use Robot\Core\DTO\Action as ActionModel;

class Action
{
    /**
     * @param ActionModel[] $response
     * @return array
     */
    public static function mapActionsResponseToModel(array $response): array
    {
        $items = [];
        foreach ($response as $item) {
            $items[] = new ActionModel(
                id: $item["ID"],
                name: $item["NAME"],
                description: $item["DETAIL_TEXT"] ?? ""
            );
        }

        return $items;
    }
}