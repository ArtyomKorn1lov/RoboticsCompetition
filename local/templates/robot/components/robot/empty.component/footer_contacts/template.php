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

use Bitrix\Main\Localization\Loc;
use Robot\Core\Tools\Template\Helper;

if (empty($arResult["SETTINGS"])) {
    return;
}

Loc::loadMessages(__FILE__);

/** @var Robot\Core\DTO\SiteSettings\SiteSettingsFooter $siteSettings */
$siteSettings = $arResult["SETTINGS"];

$isMainPage = $arParams["IS_MAIN_PAGE"];
?>

<div class="b-footer__wrap">
    <div class="b-footer__logo">
        <?php if (!empty($siteSettings->logoFooter)) { ?>
            <?php if ($isMainPage) { ?>
                <div class="b-footer__logo-wrap">
            <?php } else { ?>
                <a class="b-footer__logo-wrap" href="<?= SITE_DIR ?>">
            <?php } ?>
                    <img class="b-footer__logo-icon"
                        src="<?= $siteSettings->logoFooter ?>"
                        alt="<?= $siteSettings->siteName ?>">
            <?php if ($isMainPage) { ?>
                </div>
            <?php } else { ?>
                </a>
            <?php } ?>
        <?php } ?>
        <div class="b-footer__title-wrap">
            <div class="b-footer__title">
                <?= $siteSettings->siteName ?>
            </div>
            <?php $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "custom_wrapper",
                array(
                    "CUSTOM_WRAPPER_START" => '<span class="b-footer__copyright">',
                    "CUSTOM_WRAPPER_END" => '</span>',
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => SITE_DIR."include/copyright.php",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "COMPONENT_TEMPLATE" => ".default",
                    "EDIT_TEMPLATE" => "standard.php"
                ),
                $component
            ); ?>
        </div>
    </div>

    <div class="b-footer__contact">
        <?php if (!empty($siteSettings->email)) { ?>
            <?php foreach ($siteSettings->email as $key => $item) { ?>
                <a href="mailto:<?= $item ?>" class="b-footer__contact-item b-footer__contact-item_link">
                    <span class="b-footer__contact-icon">
                        <?php if ($key === 0) { ?>
                            <?= Helper::getIcon("mail_footer"); ?>
                        <?php } ?>
                   </span>
                    <span class="b-footer__contact-label">
                        <?= $item ?>
                    </span>
                </a>
            <?php } ?>
        <?php } ?>
        <?php if (!empty($siteSettings->phone)) { ?>
            <?php foreach ($siteSettings->phone as $key => $item) { ?>
                <a href="tel:<?= Helper::convertPhoneTelFormat($item) ?>" class="b-footer__contact-item b-footer__contact-item_link">
                    <span class="b-footer__contact-icon">
                        <?php if ($key === 0) { ?>
                            <?= Helper::getIcon("phone_footer"); ?>
                        <?php } ?>
                    </span>
                    <span class="b-footer__contact-label">
                        <?= $item ?>
                    </span>
                </a>
            <?php } ?>
        <?php } ?>
    </div>

    <div class="b-footer__contact">
        <?php if (!empty($siteSettings->address)) { ?>
            <div class="b-footer__contact-item">
                <span class="b-footer__contact-icon">
                    <?= Helper::getIcon("address_footer"); ?>
                </span>
                <span class="b-footer__contact-label b-footer__contact-label_description">
                    <?= $siteSettings->address ?>
                </span>
            </div>
        <?php } ?>
        <?php if (!empty($siteSettings->socialNetworks)) { ?>
            <div class="b-footer__contact-item b-footer__contact-item_social">
                <span class="b-footer__contact-label b-footer__contact-label_social">
                    <?= Loc::getMessage("SOCIAL_NETWORK_TITLE") ?>
                </span>
                <?php foreach ($siteSettings->socialNetworks as $key => $item) { ?>
                    <a href="<?= $item ?>" class="b-footer__contact-icon b-footer__contact-icon_social">
                        <?= Helper::getIcon($key); ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
