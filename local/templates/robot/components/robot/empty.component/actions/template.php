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

use Bitrix\Main\Localization\Loc;
use Robot\Core\DTO\Action;

Loc::loadMessages(__FILE__);

if (empty($arResult["ITEMS"])) {
    ShowError(Loc::getMessage("COMPONENT_ITEMS_EMPTY_ERROR"));
    return;
}

?>

<div class="b-section b-section_pb b-action">
    <h2 class="b-section__title b-action__title">
        <?= Loc::getMessage("COMPONENT_TITLE") ?>
    </h2>
    <div class="b-action__section">
        <?php
        /** @var Action $item */
        foreach ($arResult["ITEMS"] as $item) { ?>
            <div class="b-action__item" id="<?= $item->id ?>">
                <span class="b-action__name">
                    <?= $item->name ?>
                </span>
                <?php if (!empty($item->description)) { ?>
                    <div class="b-action__description">
                        <?= $item->description ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
