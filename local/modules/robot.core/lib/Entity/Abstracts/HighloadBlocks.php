<?php

namespace Robot\Core\Entity\Abstracts;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;

abstract class HighloadBlocks
{
    /**
     * @return void
     * @throws LoaderException
     */
    protected function includeHighloadBlocksModule(): void
    {
        if (!Loader::includeModule("highloadblock")) {
            throw new LoaderException("Ошибка подключения модуля highloadblock");
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
            throw new ObjectException("Сущность $entityName не найдена");
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
            throw new ObjectException("Класс сущности $entityName не найден");
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