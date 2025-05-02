<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

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
     * @throws ArgumentException
     */
    public static function getMap(): array
    {
        return [
            (new IntegerField("id"))
                ->configurePrimary()
                ->configureAutocomplete()
                ->configureTitle(Loc::getMessage("ROBOT_FORM_TYPE_ID_TITLE")),
            (new StringField("name"))
                ->configureColumnName("UF_NAME")
                ->configureTitle(Loc::getMessage("ROBOT_FORM_TYPE_NAME_TITLE")),
            (new StringField("code"))
                ->configureColumnName("UF_CODE")
                ->configureTitle(Loc::getMessage("ROBOT_FORM_TYPE_CODE_TITLE")),
            (new IntegerField("sort"))
                ->configureColumnName("UF_SORT")
                ->configureTitle(Loc::getMessage("ROBOT_FORM_TYPE_SORT_TITLE")),
            (new OneToMany("formType", RegistrationFieldsTable::class, "formTypeId"))
                ->configureJoinType(Join::TYPE_INNER)
        ];
    }
}