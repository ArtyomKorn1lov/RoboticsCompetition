<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Localization\Loc;
use Robot\Core\Views\Events\EventsView;

Loc::loadMessages(__FILE__);

$arResult["JS_DATA"]["formFields"] = [
    "groups" => [
        [
            "title" => Loc::getMessage("COMPONENT_TITLE"),
            "code" => "register-fields",
            "items" => EventsView::getRegistrationFormFields()->mapToArray(function ($item) {
                $item->values = $item->values->mapToArray(fn($item) => $item);
                return $item;
            })
        ]
    ]
];