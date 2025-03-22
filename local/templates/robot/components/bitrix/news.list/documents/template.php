<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

use Robot\Core\Tools\Template\Helper;

if (empty($arResult["ITEMS"])) {
    return;
}
?>
<div class="b-section b-section_pb b-section_last">
<div class="b-docs">
    <?php foreach ($arResult["ITEMS"] as $item) { ?>
        <?php
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $name = $item["NAME"];
        $document = $item["DISPLAY_PROPERTIES"]["DOCUMENT"]["FILE_VALUE"]["SRC"];
        ?>
        <a
                class="b-docs__item"
                target="_blank"
                href="<?= $document ?>"
                id="<?= $this->GetEditAreaId($item['ID']); ?>"
        >
            <span class="b-docs__icon">
                <?= Helper::getIcon("document"); ?>
            </span>
            <?= $name ?>
        </a>
    <?php } ?>
</div>
</div>