<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\EventManager;
use Bitrix\Main\UserField\Types\StringType;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler('main', 'OnUserTypeBuildList', [CUserTypeTime::class, 'GetUserTypeDescription']);

// TODO перенести обработчики в модуль
class CUserTypeTime extends StringType
{
    const USER_TYPE_ID = 'time';

    public static function getDescription(): array
    {
        return [
            'DESCRIPTION' => 'Время (HH:MM)',
            'BASE_TYPE' => CUserTypeManager::BASE_TYPE_STRING,
        ];
    }

    public static function getDbColumnType(): string
    {
        return 'char(5)';
    }
}

require dirname( __DIR__, 2) . "/vendor/autoload.php";