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

$isMainPage = $arParams["IS_MAIN_PAGE"];
?>
<div class="b-header__site">
    <?php if (!empty($siteSettings->logo)) { ?>
        <?php if ($isMainPage) { ?>
            <div class="b-header__logo-wrap">
        <?php } else { ?>
            <a href="<?= SITE_DIR ?>" class="b-header__logo-wrap">
        <?php } ?>
                <img class="b-header__logo" src="<?= $siteSettings->logo ?>" alt="<?= $siteSettings->siteName ?>">
        <?php if ($isMainPage) { ?>
            </div>
        <?php } else { ?>
            </a>
        <?php } ?>
    <?php } ?>
    <h1 class="b-header__title">
        <?= $siteSettings->siteName ?>
    </h1>
</div>
