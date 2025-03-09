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

/** @var Robot\Core\DTO\SiteSettings\SiteSettingsContacts $siteSettings */
$siteSettings = $arResult["SETTINGS"];
?>

<div class="b-section b-section_pb b-section_last b-contacts">
    <div class="b-contacts__left">
        <h1 class="b-main__title b-contacts__title">
            <?=$APPLICATION->GetTitle(false, true)?>
        </h1>
        <div class="b-contacts__info">
            <?php if (!empty($siteSettings->addressOrganisation)) { ?>
                <div class="b-contacts__group">
                    <span class="b-contacts__subtitle">
                        <?= Loc::getMessage("ADDRESS_TITLE") ?>
                    </span>
                    <div class="b-contacts__list">
                        <?php foreach ($siteSettings->addressOrganisation as $key => $item) {  ?>
                            <span class="b-contacts__item">
                                <b><?= $key ?></b> <?= $item ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($siteSettings->contactPhones)) { ?>
                <div class="b-contacts__group">
                    <span class="b-contacts__subtitle">
                        <?= Loc::getMessage("PHONE_TITLE") ?>
                    </span>
                    <div class="b-contacts__list">
                        <?php foreach ($siteSettings->contactPhones as $key => $item) { ?>
                            <span class="b-contacts__item">
                                <b><?=$key?></b> <a class="b-contacts__link" href="tel:<?= Helper::convertPhoneTelFormat($item) ?>"><?= $item ?></a>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($siteSettings->email)) { ?>
                <div class="b-contacts__group">
                    <span class="b-contacts__subtitle">
                        <?= Loc::getMessage("EMAIL_TITLE") ?>
                    </span>
                    <div class="b-contacts__list">
                        <?php foreach ($siteSettings->email as $item) { ?>
                            <span class="b-contacts__item">
                                <a class="b-contacts__link" href="mailto:<?= $item ?>"><?= $item ?></a>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($siteSettings->socialNetworks)) { ?>
                <div class="b-contacts__group">
                <span class="b-contacts__subtitle">
                    <?= Loc::getMessage("SOCIAL_NETWORK_TITLE") ?>
                </span>
                    <div class="b-contacts__list">
                        <?php foreach ($siteSettings->socialNetworks as $key => $item) { ?>
                            <span class="b-contacts__item">
                            <a href="<?= $item ?>" target="_blank" class="b-contacts__icon">
                                <?= Helper::getIcon($key) ?>
                            </a>
                        </span>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="b-contacts__map">

    </div>
</div>