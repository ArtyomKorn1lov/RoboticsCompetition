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

<div>
    <?php if (!empty($arResult["DETAIL_PICTURE"]["SRC"])) { ?>
        <div>
            <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" alt="<?= $arResult["NAME"] ?>">
        </div>
    <?php } ?>
    <h3><?= $arResult["NAME"] ?></h3>
    <p><?= $arResult["DISPLAY_PROPERTIES"]["EVENT_DATES"]["DISPLAY_VALUE"] ?></p>
    <?php if (!empty($arResult["DETAIL_TEXT"])) { ?>
        <p>
            <?= $arResult["DETAIL_TEXT"] ?>
        </p>
    <?php } ?>
    <?php if ($showActiveRegistration) { ?>
        <a href="<?=Constants::REGISTRATION_URL?>">
            <?=Loc::getMessage("EVENT_PARTICIPATE_BTN")?>
        </a>
    <?php } ?>
</div>