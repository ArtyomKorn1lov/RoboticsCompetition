<?php

namespace Robot\Core\Repositories\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\ObjectException;
use Bitrix\Main\SystemException;
use CIBlockElement;

use Robot\Core\Constants;
use Robot\Core\Entity\Abstracts\HighloadBlocks;
use Robot\Core\Entity\Event\FormField;
use Robot\Core\Entity\Event\RegisterForm;
use Robot\Core\Entity\Event\RegistrationFieldsTable;
use Robot\Core\Tools\IBlocks\Helper;

class EventRepository extends HighloadBlocks implements IEventRepository
{
    /**
     * @param RegisterForm $registerFormEntity
     * @return void
     * @throws ObjectException
     */
    public function saveForm(RegisterForm $registerFormEntity): void
    {
        $entity = new CIBlockElement();
        if (!$entity->Add($registerFormEntity->getFormData())) {
            throw new ObjectException($entity->LAST_ERROR);
        }
    }

    /**
     * @return int
     */
    public function getLastElementId(): int
    {
        $rsObject = CIBlockElement::GetList(["ID" => "DESC"], [
            "IBLOCK_ID" => Helper::getIblock(Constants::REGISTRATION_REQUEST_IBLOCK_CODE),
            "IBLOCK_TYPE" => Constants::FEEDBACK_IBLOCK_TYPE,
        ], false, ["nTopCount" => 1], ["ID"]);

        $result = $rsObject->fetch();
        if (empty($result)) {
            return 1;
        }

        return $result["ID"];
    }

    /**
     * @param bool $isInit
     * @return FormField[]
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getRegistrationFields(bool $isInit = true): array
    {
        // TODO первично найденный способ, уточнить какой лучше способ
        /*$query = RegistrationFieldsTable::getList([
            "order" => [
                "sort" => "ASC"
            ],
            "select" => [
                "*",
                "FORMTYPE"
            ]
        ]);

        $result = [];
        while ($item = $query->fetchObject()) {
            $fieldType = $item->getFormtype();

            $result[] = [
                "id" => $item->getId(),
                "code" => $item->getCode(),
                "name" => $item->getName(),
                "required" => $item->getRequired(),
                "typeField" => $fieldType->collectValues(),
                "values" => $item->getValues()
            ];
        }*/

        $query = new Query(RegistrationFieldsTable::getEntity());
        $query->setOrder(["sort" => "ASC"]);
        $query->setSelect([
            "*",
            "formType"
        ]);
        $rsObject = $query->exec();

        $result = [];
        while ($item = $rsObject->fetchObject()) {
            $fieldType = $item->getFormtype();

            $result[] = new FormField(
                $item->getId(),
                $item->getCode(),
                $fieldType->getCode(),
                $item->getRequired(),
                $item->getName(),
                $item->getPlaceholder(),
                $item->getValues(),
                $isInit
            );
        }
        return $result;
    }

    /**
     * @param int $id
     * @return string
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getFieldValueEntityById(int $id): string
    {
        $entity = RegistrationFieldsTable::getByPrimary($id, [
            "select" => [ "values" ]
        ])->fetchObject();
        if (empty($entity)) {
            return "";
        }
        return $entity->getValues();
    }

    /**
     * @param string $value
     * @param string $entityName
     * @return array
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws LoaderException
     */
    public function searchAutocompleteValues(string $value, string $entityName): array
    {
        $arData = $this->getEntityItemsByName(
            $entityName,
            [
                Constants::UF_FIELD_CODE_VALUE
            ],
            [
                Constants::UF_FIELD_CODE_SORT => "ASC"
            ],
            [
                Constants::UF_FIELD_CODE_VALUE => "%$value%"
            ]
        );

        $result = [];
        foreach ($arData as $item) {
            $result[] = $item[Constants::UF_FIELD_CODE_VALUE];
        }

        return $result;
    }
}