<?
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
$this->setFrameMode(true);

?>
<?php if (!empty($arParams["CUSTOM_WRAPPER_START"])) { ?>
    <?= htmlspecialchars_decode($arParams["CUSTOM_WRAPPER_START"]) ?>
<?php } ?>
<?php
if($arResult["FILE"] <> '') {
    include($arResult["FILE"]);
}
?>
<?php if (!empty($arParams["CUSTOM_WRAPPER_END"])) { ?>
    <?= htmlspecialchars_decode($arParams["CUSTOM_WRAPPER_END"]) ?>
<?php } ?>
