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
        $link = $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?? false;
        ?>
        <?php if ($link) { ?>
            <a
                class="b-partners__item"
                id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
                href="<?= $link ?>"
                title="<?= $arItem["NAME"] ?>"
                target="_blank"
                style="--background-partner: url('<?= $arItem["DETAIL_PICTURE"]["SRC"] ?>');
                       --background-partner-active: url('<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?? $arItem["DETAIL_PICTURE"]["SRC"] ?>');"
            >
        <?php } else { ?>
            <div
                class="b-partners__item"
                id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
                style="--background-partner: url('<?= $arItem["DETAIL_PICTURE"]["SRC"] ?>');
                       --background-partner-active: url('<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?? $arItem["DETAIL_PICTURE"]["SRC"] ?>');"
            >
        <?php } ?>
        <?php if ($link) { ?>
            </a>
        <?php } else { ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>
    