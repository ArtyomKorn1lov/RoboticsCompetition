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

use Robot\Core\Constants;
use Robot\Core\Tools\Template\Helper;

if (empty($arResult["ITEMS"])) {
    return;
}
?>
<div class="b-section b-section_pb">
<ul style="display: flex; flex-direction: column; gap: 30px;">
    <?php foreach ($arResult["ITEMS"] as $item) { ?>
        <?php
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $name = $item["NAME"];
        $document = $item["DISPLAY_PROPERTIES"]["DOCUMENT"]["FILE_VALUE"]["SRC"];
        $isPdf = $item["DISPLAY_PROPERTIES"]["DOCUMENT"]["FILE_VALUE"]["CONTENT_TYPE"] === Constants::PDF_FORMAT_NEWS_LIST;
        ?>
        <li style="display: flex; align-items: center; gap: 15px;" id="<?= $this->GetEditAreaId($item['ID']); ?>">
            <span style="width: 32px; height: 32px;">
                <?= Helper::getIcon( $isPdf ? "pdf_document" : "word_document", "svg_document"); ?>
            </span>
            <a href="<?= $document ?>" target="_blank">
                <?= $name ?>
            </a>
        </li>
    <?php } ?>
</ul>
</div>