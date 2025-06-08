<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "MODULES_CODES" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("COMPONENT_MODULES_PROP_TITLE"),
            "TYPE" => "STRING",
            "MULTIPLE" => "Y"
        ],
        "CACHE_TIME" => ["DEFAULT" => 36000000],
    ],
];