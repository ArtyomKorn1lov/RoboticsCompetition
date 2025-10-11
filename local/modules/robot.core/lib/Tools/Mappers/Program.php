<?php

namespace Robot\Core\Tools\Mappers;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;

use Robot\Core\DTO\Program\DateCollection as DateCollectionModel;
use Robot\Core\DTO\Program\DateUnit as DateUnitModel;
use Robot\Core\Entity\Program\DateCollection;
use Robot\Core\Entity\Program\DateUnit;
use Robot\Core\Entity\Program\ProgramCollection as ProgramCollectionEntity;
use Robot\Core\Entity\Program\Program as ProgramEntity;
use Robot\Core\DTO\Program\ProgramCollection as ProgramCollectionModel;
use Robot\Core\DTO\Program\Program as ProgramModel;
use Robot\Core\Exceptions\RobotException;

class Program
{
    /**
     * @param array $items
     * @return ProgramCollectionEntity
     * @throws RobotException
     */
    public static function mapProgramArrayToEntityList(array $items): ProgramCollectionEntity
    {
        $collection = new ProgramCollectionEntity();
        foreach ($items as $item) {
            $collection->add(new ProgramEntity(
                $item["ID"],
                $item["NAME"],
                $item["PROPERTY_LOCATION_VALUE"],
                $item["PROPERTY_TIME_VALUE"]
            ));
        }
        return $collection;
    }

    /**
     * @param array $items
     * @return DateCollection
     * @throws ArgumentException
     * @throws ObjectException
     * @throws RobotException
     */
    public static function mapDateArrayToEntityList(array $items): DateCollection
    {
        $collection = new DateCollection();
        foreach ($items as $item) {
            $collection->add(new DateUnit($item));
        }
        return $collection;
    }

    /**
     * @param ProgramCollectionEntity $collectionEntity
     * @return ProgramCollectionModel
     */
    public static function mapProgramCollectionToModels(ProgramCollectionEntity $collectionEntity): ProgramCollectionModel
    {
        $collectionModel = new ProgramCollectionModel();
        foreach ($collectionEntity as $item) {
            $collectionModel->add(new ProgramModel(
                id: $item->id,
                name: $item->name,
                location: $item->location,
                timeLine: $item->getTimeRange()
            ));
        }
        return $collectionModel;
    }

    /**
     * @param DateCollection $collectionEntity
     * @return DateCollectionModel
     */
    public static function mapDateCollectionToModels(DateCollection $collectionEntity): DateCollectionModel
    {
        $collectionModel = new DateCollectionModel();
        /** @var DateUnit $item */
        foreach ($collectionEntity as $item) {
            $collectionModel->add(new DateUnitModel(
                date: $item->getFormattedString(),
                dateString: $item->getDateString()
            ));
        }
        return $collectionModel;
    }
}