<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

global $APPLICATION;

if (!Bitrix\Main\Loader::includeModule('robot.core')) {
    ShowError(Loc::getMessage("ERROR_INCLUDE_MODULE"));
    die();
}

use Robot\Core\Tools\Modules\Manager;
use Robot\Core\Constants;
use Robot\Core\Tools\Template\Helper;

Manager::includeFrontendPlugins();

?>
<!doctype html>
<html lang="<?=LANGUAGE_ID?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php Helper::includeFontsCSS(); ?>
    <?php $APPLICATION->ShowHead();?>
    <title><?php $APPLICATION->ShowTitle()?></title>
</head>
<?php Helper::createJSGlobalSiteTemplatePath(); ?>
<body class="custom-scroll">

<div class="mainContainer">
<div id="panel"><?php $APPLICATION->ShowPanel(); ?></div>

<header class="b-header">

    <div class="b-header__wrap">

        <?php
        $APPLICATION->IncludeComponent(
        "robot:template.component",
        "header_name",
            Array(
                "IS_MAIN_PAGE" => ($APPLICATION->GetCurPage(false) === SITE_DIR),
                "MODULES_CODES" => array("robot.core","")
            ),
            false
        );?>

        <div class="b-header__controls">
            <?php $APPLICATION->IncludeComponent("bitrix:menu", "main", array(
	            "ROOT_MENU_TYPE" => "top",
		        "MAX_LEVEL" => "1",
		        "CHILD_MENU_TYPE" => "top",
		        "USE_EXT" => "Y",
		        "DELAY" => "N",
		        "ALLOW_MULTI_SELECT" => "Y",
		        "MENU_CACHE_TYPE" => "N",
		        "MENU_CACHE_TIME" => "3600",
		        "MENU_CACHE_USE_GROUPS" => "Y",
		        "MENU_CACHE_GET_VARS" => "",
	        ),
	        false
            );?>

            <?php
            $isEnLanguage = LANGUAGE_ID === Constants::LANG_ENGLISH_CODE;
            ?>
            <a href="<?= $isEnLanguage ? "/" : "/en/" ?>" class="b-header__lang">
                <span class="b-header__lang-icon-wrap">
                    <img
                        class="b-header__lang-icon"
                        src="<?=SITE_TEMPLATE_PATH?>/app/dist/assets/images/<?=$isEnLanguage ? "flag_english" : "flag_russia"?>.svg"
                        alt="<?=Loc::getMessage("HEADER_LANG_TITLE")?>"
                    >
                </span>
                <?= Loc::getMessage("HEADER_LANG_TITLE"); ?>
            </a>

            <div class="b-header__burger-wrap">
                <?php $APPLICATION->IncludeComponent("bitrix:menu", "burger", array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "top",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "Y",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => "",
                ),
                    false
                ); ?>
            </div>
        </div>
    </div>
</header>
<main class="b-main b-main_centered">
    <?php if ($APPLICATION->GetCurPage(false) !== SITE_DIR && !(defined('ERROR_404') && ERROR_404 === 'Y')) { ?>
        <?php $APPLICATION->IncludeComponent(
            "bitrix:breadcrumb",
            "main",
            array(
                "PATH" => "",
                "SITE_ID" => SITE_ID,
                "START_FROM" => "0"
            )
        ); ?>
    <?php } ?>

    <?php Robot\Core\Tools\Template\Helper::showTitle() ?>