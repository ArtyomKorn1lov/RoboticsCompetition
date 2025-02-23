<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$arResult["JS_DATA"]["items"] = [];
foreach ($arResult["ITEMS"] as $item) {
    $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    $file = $item["DISPLAY_PROPERTIES"]["FILE"]["FILE_VALUE"];
    $arResult["JS_DATA"]["items"][] = [
        "areaId" => $this->GetEditAreaId($item['ID']),
        "name" =>  $item["NAME"],
        "description" => $item["PREVIEW_TEXT"],
        "preview" => $item["PREVIEW_PICTURE"]["SRC"] ?? false,
        "file" => [
            "url" => $file["SRC"],
            "type" => $file["CONTENT_TYPE"]
        ]
    ];
}