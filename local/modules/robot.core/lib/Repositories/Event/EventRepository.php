<?php

namespace Robot\Core\Repositories\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\SystemException;
use CIBlockElement;

use Robot\Core\Entity\Event\ActiveEventReqParams;
use Robot\Core\Base\HighloadBlocks;
use Robot\Core\Constants;
use Robot\Core\Entity\Event\EventDetailReqParams;
use Robot\Core\Entity\Event\FormField;
use Robot\Core\Entity\Event\FormFieldCollection;
use Robot\Core\Entity\Event\RegisterForm;
use Robot\Core\Entity\Event\RegistrationFieldsTable;
use Robot\Core\Exceptions\RobotException;
use Robot\Core\Tools\IBlocks\Helper;

class EventRepository extends HighloadBlocks implements IEventRepository
{
    /**
     * @param ActiveEventReqParams $apiParams
     * @return array
     */
    public function getActiveEvent(ActiveEventReqParams $apiParams): array
    {
        $rsObject = CIBlockElement::GetList(
            arOrder: $apiParams->getSortValues(),
            arFilter: $apiParams->getFilterValues(),
            arNavStartParams: ["nTopCount" => 1],
            arSelectFields: $apiParams->getSelectedFields()
        );
        $item = $rsObject->fetch();
        if (!$item) {
            return [];
        }
        return $item;
    }

    /**
     * @param RegisterForm $registerFormEntity
     * @return int
     * @throws ObjectException
     */
    public function saveRegisterForm(RegisterForm $registerFormEntity): int
    {
        $entity = new CIBlockElement();
        $itemId = $entity->Add($registerFormEntity->getFormData());
        if (!$itemId) {
            throw new ObjectException($entity->LAST_ERROR);
        }
        return $itemId;
    }

    /**
     * @return int
     */
    public function getLastElementId(): int
    {
        $rsObject = CIBlockElement::GetList(
            arOrder: ["ID" => "DESC"],
            arFilter: [
                "IBLOCK_ID" => Helper::getIBlock(Constants::REGISTRATION_REQUEST_IBLOCK_CODE),
                "IBLOCK_TYPE" => Constants::FEEDBACK_IBLOCK_TYPE,
            ],
            arNavStartParams: ["nTopCount" => 1],
            arSelectFields: ["ID"]
        );

        $result = $rsObject->fetch();
        if (empty($result)) {
            return 1;
        }

        return $result["ID"];
    }

    /**
     * @param bool $isInit
     * @return FormFieldCollection
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getRegistrationFields(bool $isInit = true): FormFieldCollection
    {
        $query = new Query(RegistrationFieldsTable::getEntity());
        $query->setOrder(["sort" => "ASC"]);
        $query->setFilter(["lang" => Loc::getCurrentLang()]);
        $query->setSelect([
            "*",
            "formType"
        ]);
        $rsObject = $query->exec();

        $collection = new FormFieldCollection();
        while ($item = $rsObject->fetchObject()) {
            $fieldType = $item->getFormtype();

            $collection->add(new FormField(
                $item->getId(),
                $item->getCode(),
                $fieldType->getCode(),
                $item->getRequired(),
                $item->getName(),
                $item->getPlaceholder(),
                $item->getValues(),
                $isInit
            ));
        }
        return $collection;
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
            entityName: $entityName,
            arSelectParams: [
                Constants::UF_FIELD_CODE_VALUE
            ],
            orderParams: [
                Constants::UF_FIELD_CODE_SORT => "ASC"
            ],
            filterParams: [
                Constants::UF_FIELD_CODE_VALUE => "%$value%"
            ]
        );

        $result = [];
        foreach ($arData as $item) {
            $result[] = $item[Constants::UF_FIELD_CODE_VALUE];
        }

        return $result;
    }

    /**
     * @param EventDetailReqParams $entity
     * @return array
     * @throws RobotException
     */
    public function getEventById(EventDetailReqParams $entity): array
    {
        $rsObject = CIBlockElement::GetList(
            arOrder: $entity->getSortValues(),
            arFilter: $entity->getFilterValues(),
            arNavStartParams: ["nTopCount" => 1],
            arSelectFields: $entity->getSelectedFields()
        );

        $item = $rsObject->fetch();
        if (!$item) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_EVENTS_GET_EMPTY"));
        }

        return $item;
    }
}