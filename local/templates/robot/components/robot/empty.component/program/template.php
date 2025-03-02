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

use Robot\Core\DTO\Program\ProgramItems;
use Bitrix\Main\Web\Json;

/** @var ProgramItems $programItems */
$programItems = $arResult["PROGRAM_ITEMS"];

$programItems->templateId = "program" . $this->randString();

$arJsData = Json::encode($programItems);
?>

<div id="<?=$programItems->templateId?>"></div>
<script>
    BX.ready(() => {
        BX.Robot.Components.Vue.ProgramList(<?=$arJsData?>);
    });
</script>

