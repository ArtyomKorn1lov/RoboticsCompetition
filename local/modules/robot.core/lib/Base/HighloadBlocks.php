<?php

namespace Robot\Core\Base;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

Loc::loadMessages(__FILE__);

abstract class HighloadBlocks
{
    /**
     * @return void
     * @throws LoaderException
     */
    protected function includeHighloadBlocksModule(): void
    {
        if (!Loader::includeModule("highloadblock")) {
            throw new LoaderException(Loc::getMessage("ROBOT_CORE_HL_MODULE_NOT_INCLUDE"));
        }
    }

    /**
     * @param string $entityName
     * @return int
     * @throws ObjectException
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    protected function getIdByEntityName(string $entityName): int
    {
        $data = HighloadBlockTable::getList([
            "filter" => [ "=NAME" => $entityName ],
            "select" => [ "ID" ]
        ])->fetch();

        if (empty($data["ID"])) {
            throw new ObjectException(Loc::getMessage("ROBOT_CORE_ENTITY_NOT_FOUND", ["#ENTITY#" => $entityName]));
        }

        return $data["ID"];
    }

    /**
     * @param string $entityName
     * @param array $arSelectParams
     * @param array $orderParams
     * @param array $filterParams
     * @return array
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    protected function getEntityItemsByName(string $entityName, array $arSelectParams = [], array $orderParams = [], array $filterParams = []): array
    {
        $this->includeHighloadBlocksModule();

        $hlblock = HighloadBlockTable::getById($this->getIdByEntityName($entityName))->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        if (empty($entity_data_class)) {
            throw new ObjectException(Loc::getMessage("ROBOT_CORE_ENTITY_CLASS_NOT_FOUND", ["#ENTITY#" => $entityName]));
        }

        $rsObject = $entity_data_class::getList([
            "select" => $arSelectParams,
            "order" => $orderParams,
            "filter" => $filterParams
        ]);

        $result = [];
        while ($item = $rsObject->fetch()) {
            $result[] = $item;
        }

        return $result;
    }
}