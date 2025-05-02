<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Entity\BooleanField;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;

Loc::loadMessages(__FILE__);

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
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_ID_TITLE")),
            (new StringField("name"))
                ->configureColumnName("UF_NAME")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_NAME_TITLE")),
            (new StringField("code"))
                ->configureColumnName("UF_CODE")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_CODE_TITLE")),
            (new IntegerField("sort"))
                ->configureColumnName("UF_SORT")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_SORT_TITLE")),
            (new StringField("xml_id"))
                ->configureColumnName("UF_XML_ID")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_XML_ID_TITLE")),
            (new StringField("placeholder"))
                ->configureColumnName("UF_PLACEHOLDER")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_PLACEHOLDER_TITLE")),
            (new BooleanField("required"))
                ->configureColumnName("UF_REQUIRED")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_REQUIRED_TITLE")),
            (new IntegerField("formTypeId"))
                ->configureColumnName("UF_FIELD_TYPE")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_TYPE_TITLE")),
            (new Reference("formType", FormTypesTable::class, Join::on("this.formTypeId", "ref.id")))
                ->configureJoinType('inner'),
            (new StringField("values"))
                ->configureColumnName("UF_VALUES")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_SELECT_AUTOCOMPLETE_TITLE")),
            (new StringField("lang"))
                ->configureColumnName("UF_LANG")
                ->configureTitle(Loc::getMessage("ROBOT_REGISTRATION_FIELD_LANG_TITLE")),
        ];
    }
}