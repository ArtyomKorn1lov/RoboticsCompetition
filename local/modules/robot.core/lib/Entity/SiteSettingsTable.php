<?php

namespace Robot\Core\Entity;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\TextField;
use Bitrix\Main\Entity\Validator\Length;
use Bitrix\Main\Entity\Validator\Unique;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);

class SiteSettingsTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return "robot_core_settings";
    }

    /**
     * @return array
     * @throws SystemException
     * @throws ArgumentException
     */
    public static function getMap()
    {
        return [
            'ID' => new IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_ID_FIELD'),
            ]),
            'SITE_ID' => new StringField('SITE_ID', [
                'required' => true,
                'validation' => [__CLASS__, 'validateSiteId'],
                'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_SITE_ID_FIELD'),
            ]),
            new ReferenceField('SITE',
                '\\Bitrix\\Main\\SiteTable',
                ['=this.SITE_ID' => 'ref.LID']
            ),
            new ExpressionField(
                'SITE_NAME',
                '%s',
                ['SITE.NAME'],
                [
                    'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_SITE_NAME_FIELD'),
                ]
            ),
            'EMAIL' => new StringField('EMAIL', [
                'validation' => [__CLASS__, 'validateEmail'],
                'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_EMAIL_FIELD'),
            ]),
            'PHONE' => new StringField('PHONE', [
                'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_PHONE_FIELD'),
            ]),
            'ADDRESS' => new StringField('ADDRESS', [
                'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_ADDRESS_FIELD'),
            ]),
            'SOCIAL_NETWORKS' => new TextField('SOCIAL_NETWORKS', [
                'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_SOCIAL_FIELD'),
                'serialized' => true
            ]),
            'LOGO' => new IntegerField('LOGO', [
                'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_LOGO_FIELD')
            ]),
            'LOGO_FOOTER' => new IntegerField('LOGO_FOOTER', [
                'title' => Loc::getMessage('ROBOT_SITE_SETTINGS_ENTITY_LOGO_FOOTER_FIELD')
            ]),
        ];
    }

    /**
     * @throws ArgumentTypeException
     */
    public static function validateSiteId(): array
    {
        return array(
            new Length(null, 2),
            new Unique(),
        );
    }

    /**
     * @throws ArgumentTypeException
     */
    public static function validateEmail(): array
    {
        return array(
            new Length(null, 255),
        );
    }
}