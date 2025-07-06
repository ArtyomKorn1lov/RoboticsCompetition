<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    "NAME" => Loc::getMessage("MAIN_INCLUDE_COMPONENT_NAME"),
    "DESCRIPTION" => Loc::getMessage("MAIN_INCLUDE_COMPONENT_DESCR"),
    "PATH" => [
        "ID" => "content"
    ],
];