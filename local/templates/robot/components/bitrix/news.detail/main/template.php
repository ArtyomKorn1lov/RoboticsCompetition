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
$this->setFrameMode(true);

use Robot\Core\Constants;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$showActiveRegistration = !empty($arResult["DISPLAY_PROPERTIES"]["ACTIVE_REGISTRATION"]["DISPLAY_VALUE"])
    && $arResult["DISPLAY_PROPERTIES"]["ACTIVE_REGISTRATION"]["DISPLAY_VALUE"] === "Y";
?>

<div class="b-section b-section_pb">
    <div class="b-event">
        <div class="b-event__section">
            <time class="b-event__timeline">
                <?= $arResult["DISPLAY_PROPERTIES"]["EVENT_DATES"]["DISPLAY_VALUE"] ?>
            </time>
            <h1 class="b-event__title">
                <?= $arResult["NAME"] ?>
            </h1>
            <?php if (!empty($arResult["DETAIL_TEXT"])) { ?>
                <div class="b-event__description">
                    <?= $arResult["DETAIL_TEXT"] ?>
                </div>
            <?php } ?>
            <?php if ($showActiveRegistration) { ?>
                <a class="b-button b-button_primary b-event__button" href="<?= Constants::REGISTRATION_URL ?>">
                    <?= Loc::getMessage("EVENT_PARTICIPATE_BTN") ?>
                </a>
            <?php } ?>
        </div>
        <picture class="b-event__img-wrap">
            <?php if (!empty($arResult["DETAIL_PICTURE"]["SRC"])) { ?>
                <img class="b-event__img" src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" alt="<?= $arResult["NAME"] ?>">
            <?php } ?>
        </picture>
    </div>
</div>