<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

use Robot\Core\Views\Program\ProgramView;

$programItems = ProgramView::getPrograms();

if (!empty($programItems)) {
    $programItems->programs = $programItems->programs->mapToArray(fn($item) => $item);
    $programItems->dates = $programItems->dates->mapToArray(fn($item) => $item);
}

$arResult["PROGRAM_ITEMS"] = $programItems;