<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

global $APPLICATION;

$jsData = [];
// Если пользователь не находится на главной странице, убираем выделение пункта меню
foreach ($arResult as $key => $item) {
    if ($item["LINK"] === SITE_DIR && $APPLICATION->GetCurPage(false) !== SITE_DIR) {
        $arResult[$key]["SELECTED"] = false;
    }
    $jsData[] = [
        "title" => $arResult[$key]["TEXT"],
        "url" => $arResult[$key]["LINK"],
        "selected" => $arResult[$key]["SELECTED"]
    ];
}

$arResult["JS_DATA"]["items"] = $jsData;