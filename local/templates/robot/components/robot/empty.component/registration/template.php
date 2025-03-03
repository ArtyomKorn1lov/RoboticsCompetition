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

$arResult["JS_DATA"]["formFields"] = [
    "groups" => [
        [
            "title" => Loc::getMessage("COMPONENT_TITLE"),
            "code" => "register-fields",
            "items" => [
                [
                    "code" => "PROPERTY_NAME",
                    "title" => "ФИО участника",
                    "type" => "text",
                    "placeholder" => "ФИО участника",
                    "required" => true
                ],
                [
                    "code" => "PROPERTY_BIRTHDAY",
                    "title" => "Дата рождения",
                    "type" => "date",
                    "placeholder" => "Дата рождения",
                    "required" => true
                ],
                [
                    "code" => "PROPERTY_COUNTRY",
                    "title" => "Страна",
                    "type" => "autocomplete",
                    "placeholder" => "Страна",
                    "required" => true,
                    "items" => []
                ],
                [
                    "code" => "PROPERTY_COURSE",
                    "title" => "Курс",
                    "type" => "text",
                    "placeholder" => "Курс",
                    "required" => false
                ],
                [
                    "code" => "PROPERTY_CODE_AND_AREA_TRAINING",
                    "title" => "Шифр и наименование направления подготовки",
                    "type" => "text",
                    "placeholder" => "Шифр и наименование направления подготовки",
                    "required" => false
                ],
                [
                    "code" => "PROPERTY_PHONE",
                    "title" => "Телефон",
                    "type" => "tel",
                    "placeholder" => "Телефон",
                    "required" => true
                ],
                [
                    "code" => "PROPERTY_EMAIL",
                    "title" => "E-mail",
                    "type" => "email",
                    "placeholder" => "E-mail",
                    "required" => true
                ],
                [
                    "code" => "PREVIEW_TEXT",
                    "title" => "Комментарий",
                    "type" => "textarea",
                    "placeholder" => "Комментарий",
                    "required" => false
                ],
                [
                    "code" => "agreement",
                    "title" => "",
                    "label" => 'Согласие на обработку <a href="#" target="_blank">персональных данных</a>',
                    "type" => "checkbox",
                    "placeholder" => "",
                    "required" => true
                ],
            ]
        ]
    ]
];

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
