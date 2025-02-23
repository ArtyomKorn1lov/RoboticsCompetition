<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

?>
<div class="b-section b-section_pb b-section_last b-archive">
    <?php foreach ($arResult["SECTIONS"] as $arSection) { ?>
        <div class="b-section__top">
            <h2 class="h5 b-section__title b-archive__subtitle">
                <?= $arSection["NAME"] ?>
            </h2>
        </div>
        <div class="b-archive__list">
            <?php
            foreach ($arSection["ITEMS"] as $arElement) {
                ?>
                <?php
                $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => Loc::getMessage('CT_BCST_ELEMENT_DELETE_CONFIRM')));
                ?>
                <a
                        href="<?= $arElement["DETAIL_PAGE_URL"] ?>"
                        class="b-archive__item"
                        id="<?= $this->GetEditAreaId($arElement['ID']); ?>"
                >
                    <div class="b-archive__left">
                        <span class="h6 b-archive__name">
                            <?=$arElement["NAME"]?>
                        </span>
                        <?php if (!empty($arElement["PREVIEW_TEXT"])) { ?>
                            <p class="b-archive__description">
                                <?= $arElement["PREVIEW_TEXT"] ?>
                            </p>
                        <?php } ?>
                    </div>
                    <span class="b-archive__icon">
                        <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
                    </span>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
