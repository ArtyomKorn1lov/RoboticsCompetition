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

if (empty($arResult["ITEMS"])) {
    return;
}
?>
<div class="b-partners__list">
    <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $link = $arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"] ?? false;
        ?>
        <?php if ($link) { ?>
            <a
                class="b-partners__item"
                id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
                href="<?= $link ?>"
                title="<?= $arItem["NAME"] ?>"
                target="_blank"
            >
        <?php } else { ?>
            <div
                class="b-partners__item"
                id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
            >
        <?php } ?>
                <img class="b-partners__img" src="<?= $arItem["DETAIL_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
        <?php if ($link) { ?>
            </a>
        <?php } else { ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>
    