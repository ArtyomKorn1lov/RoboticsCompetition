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
<div class="b-section">
<div class="b-section__description<?php if (!empty($arParams["DESCRIPTION_CLASS"])) { ?> <?=$arParams["DESCRIPTION_CLASS"]?><?php } ?>">
<?php
if($arResult["FILE"] <> '') {
    include($arResult["FILE"]);
}
?>
</div>
</div>
