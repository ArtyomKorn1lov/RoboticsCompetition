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
$this->setFrameMode(true);

if (empty($arResult["SETTINGS"])) {
    return;
}
/** @var Robot\Core\DTO\SiteSettings\SiteSettingsHeader $siteSettings */
$siteSettings = $arResult["SETTINGS"];
?>

<div class="b-header__site">
    <?php if (!empty($siteSettings->logo)) { ?>
        <a href="<?= SITE_DIR ?>" class="b-header__logo-wrap">
            <img class="b-header__logo" src="<?= $siteSettings->logo ?>" alt="<?= $siteSettings->siteName ?>">
        </a>
    <?php } ?>
    <h1 class="b-header__title">
        <?= $siteSettings->siteName ?>
    </h1>
</div>
