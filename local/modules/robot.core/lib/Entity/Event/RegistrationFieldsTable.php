<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Entity\BooleanField;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;


/**
 * ORM сущность таблицы "Поля формы регистрации"
 */
class RegistrationFieldsTable extends DataManager
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return "robot_registration_fields";
    }

    /**
     * @return array
     * @throws ArgumentException|SystemException
     */
    public static function getMap(): array
    {
        return [
            (new IntegerField("id"))
                ->configurePrimary()
                ->configureAutocomplete()
                ->configureTitle("Идентификатор"),
            (new StringField("name"))
                ->configureColumnName("UF_NAME")
                ->configureTitle("Название"),
            (new StringField("code"))
                ->configureColumnName("UF_CODE")
                ->configureTitle("Код"),
            (new IntegerField("sort"))
                ->configureColumnName("UF_SORT")
                ->configureTitle("Сортировка"),
            (new StringField("xml_id"))
                ->configureColumnName("UF_XML_ID")
                ->configureTitle("Внешний код"),
            (new StringField("placeholder"))
                ->configureColumnName("UF_PLACEHOLDER")
                ->configureTitle("Внешний код"),
            (new BooleanField("required"))
                ->configureColumnName("UF_REQUIRED")
                ->configureTitle("Поле обязательное?"),
            (new IntegerField("formTypeId"))
                ->configureColumnName("UF_FIELD_TYPE")
                ->configureTitle("Тип поля"),
            (new Reference("formType", FormTypesTable::class, Join::on("this.formTypeId", "ref.id")))
                ->configureJoinType('inner'),
            (new StringField("values"))
                ->configureColumnName("UF_VALUES")
                ->configureTitle("Значения поля для типов select, autocomplete"),
        ];
    }
}