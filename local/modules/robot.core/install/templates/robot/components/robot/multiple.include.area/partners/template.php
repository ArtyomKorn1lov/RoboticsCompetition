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
<div class="<?=($arParams["WRAPPER_CLASS"])?>">
    <?php foreach ($arResult["FILES"] as $key => $file) { ?>
        <?php if ($key === 0) { ?>
            <h2 class="<?=($arParams["WRAPPER_CLASS_" . $key])?>">
                <?php if ($file <> "") { ?>
                    <?php include($file); ?>
                <?php } ?>
            </h2>
        <?php } else if ($key === 1) { ?>
            <p class="<?=($arParams["WRAPPER_CLASS_" . $key])?>">
                <?php if ($file <> "") { ?>
                    <?php include($file); ?>
                <?php } ?>
            </p>
        <?php } else { ?>
            <?php if ($file <> "") { ?>
                <?php include($file); ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>
