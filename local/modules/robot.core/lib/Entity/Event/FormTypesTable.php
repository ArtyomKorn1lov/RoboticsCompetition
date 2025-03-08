<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Query\Join;

/**
 * ORM сущность таблицы "Типы полей для формы"
 */
class FormTypesTable extends DataManager
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return "robot_form_types";
    }

    /**
     * @return array
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
                ->configureTitle("Код поля"),
            (new IntegerField("sort"))
                ->configureColumnName("UF_SORT")
                ->configureTitle("Сортировка"),
            (new OneToMany("formType", RegistrationFieldsTable::class, "formTypeId"))
                ->configureJoinType(Join::TYPE_INNER)
        ];
    }
}