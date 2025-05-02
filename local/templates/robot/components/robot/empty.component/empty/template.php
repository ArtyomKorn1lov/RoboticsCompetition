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

Loc::loadMessages(__FILE__);

global $APPLICATION;

?>

<div class="b-section b-section_empty b-empty">
    <div class="b-empty__img-wrap">
        <img
            class="b-empty__img"
            src="<?= SITE_DIR ?>local/templates/robot/app/dist/assets/images/empty.svg"
            alt="404"
        >
    </div>
    <div class="b-empty__content">
        <h1 class="b-main__title b-empty__title">
            <?= $APPLICATION->ShowTitle(false); ?>
        </h1>
        <span class="b-empty__description">
            <?= Loc::getMessage("EMPTY_DESCRIPTION") ?>
        </span>
        <a
            class="b-button b-button_primary"
            href="<?= SITE_DIR ?>"
        >
            <?= Loc::getMessage("EMPTY_BACK_TO_HOME") ?>
        </a>
    </div>
</div>
