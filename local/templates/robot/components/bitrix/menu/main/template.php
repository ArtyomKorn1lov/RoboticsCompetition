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

if (empty($arResult)) {
    return;
}

global $APPLICATION;

?>
<nav class="b-header__menu">

    <?php
    foreach ($arResult as $arItem) {
        if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
            continue;
        ?>
        <?php if ($arItem["SELECTED"]) { ?>
            <a class="b-header__menu-link b-header__menu-link_active" href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
        <?php } else { ?>
            <a class="b-header__menu-link" href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
        <?php } ?>

    <?php } ?>

</nav>