<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

use Bitrix\Main\Web\Json;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);


$templateId = "registration" . $this->randString();
$arResult["JS_DATA"]["templateId"] = $templateId;

$arJsData = Json::encode($arResult["JS_DATA"]);
?>

<div class="b-section b-section_pb b-section_last">
    <div class="b-registration">
        <div class="b-registration__form" id="<?= $templateId ?>"></div>
        <div class="b-registration__banner-wrap">
            <img class="b-registration__banner"
                 src="<?= SITE_DIR ?>local/templates/robot/app/img/registration_banner.webp"
                 alt="<?= Loc::getMessage("COMPONENT_TITLE") ?>">
        </div>
    </div>
</div>
<script>
    BX.ready(() => {
        BX.Robot.Components.Vue.Registration(<?=$arJsData?>);
    });
</script>
