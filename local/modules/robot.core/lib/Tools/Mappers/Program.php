<?php

namespace Robot\Core\Tools\Mappers;

use Robot\Core\DTO\Program\DateUnit as DateUnitModel;
use Robot\Core\Entity\Program\DateCollection;
use Robot\Core\Entity\Program\DateUnit;
use Robot\Core\Entity\Program\ProgramCollection;
use Robot\Core\Entity\Program\Program as ProgramEntity;
use Robot\Core\DTO\Program\Program as ProgramModel;

class Program
{
    /**
     * @param ProgramCollection $entity
     * @return ProgramModel[]
     */
    public static function mapProgramCollectionToModels(ProgramCollection $entity): array
    {
        $list = $entity->getList();
        $result = [];
        /** @var ProgramEntity $item */
        foreach ($list as $item) {
            $result[] = new ProgramModel(
                id: $item->id,
                name: $item->name,
                location: $item->location,
                timeLine: $item->getTimeRange()
            );
        }
        return $result;
    }

    public static function mapDateCollectionToModels(DateCollection $entity): array
    {
        $list = $entity->getList();
        $result = [];
        /** @var DateUnit $item */
        foreach ($list as $item) {
            $result[] = new DateUnitModel(
                date: $item->getFormattedString(),
                dateString: $item->getDateString()
            );
        }
        return $result;
    }
}