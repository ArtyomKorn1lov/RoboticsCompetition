<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$areaCount = !empty($arCurrentValues["INCLUDE_AREA_COUNT"]) ? (int)$arCurrentValues["INCLUDE_AREA_COUNT"] : 1;

$arTemplateParameters = [
    "TITLE" => [
        "PARENT" => "PARAMS",
        "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_WRAP_TITLE"),
        "TYPE" => "STRING",
        "DEFAULT" => ""
    ],
    "TITLE_CLASS" => [
        "PARENT" => "PARAMS",
        "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_WRAP_TITLE_CLASS"),
        "TYPE" => "STRING",
        "DEFAULT" => ""
    ],
    "WRAPPER_CLASS" => [
        "PARENT" => "PARAMS",
        "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_WRAPPER_CLASS"),
        "TYPE" => "STRING",
        "DEFAULT" => ""
    ]
];

for ($count = 0; $count < $areaCount; $count++) {
    $arTemplateParameters["WRAPPER_CLASS_" . $count] = [
        "PARENT" => "ITEM_AREA_" . $count,
        "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_WRAPPER_ITEM_CLASS"),
        "TYPE" => "STRING",
        "DEFAULT" => ""
    ];
    $arTemplateParameters["TITLE_" . $count] = [
        "PARENT" => "ITEM_AREA_" . $count,
        "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_TITLE"),
        "TYPE" => "STRING",
        "DEFAULT" => ""
    ];
}