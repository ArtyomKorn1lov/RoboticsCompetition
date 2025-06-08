<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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

if (empty($arResult["FILES"])) {
    return;
}

?>

<?php if ($arParams["TITLE_CLASS"]) { ?>
    <div class="<?=($arParams["TITLE_CLASS"])?>">
        <?= $arParams["TITLE"] ?>
    </div>
<?php } ?>
<div class="<?=($arParams["WRAPPER_CLASS"])?>">
    <?php foreach ($arResult["FILES"] as $key => $file) { ?>
        <div class="<?=($arParams["WRAPPER_CLASS_" . $key])?>">
            <?php if (!empty($arParams["TITLE_$key"])) { ?>
                <div>
                    <?= $arParams["TITLE_$key"] ?>
                </div>
            <?php } ?>
            <?php if ($file <> "") { ?>
                <div>
                    <?php include($file); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
