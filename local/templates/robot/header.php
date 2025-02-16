<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
IncludeTemplateLangFile(__FILE__);

global $APPLICATION;

if (!Bitrix\Main\Loader::includeModule('robot.core')) {
    ShowError('Ошибка! Не подключен модуль ядра сайта.');
    die();
}

use Robot\Core\Tools\Modules\Manager;
use Bitrix\Main\UI\Extension;

Manager::includeFrontendPlugins();

Extension::load([
	"robot_frontend",
	"jquery"
]);

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php $APPLICATION->ShowHead();?>
    <title><?php $APPLICATION->ShowTitle()?></title>
</head>
<body>

<div class="mainContainer">
<div id="panel"><?php $APPLICATION->ShowPanel(); ?></div>

<header class="b-header">

    <div class="b-header__wrap">

        <?php
        $APPLICATION->IncludeComponent(
        "robot:empty.component",
        "header_name",
            Array(
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "MODULES_CODES" => array("robot.core","")
            )
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

            <a href="javascript:void(0)" class="b-header__lang">
                <span class="b-header__lang-icon">
                    <svg>
                        <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#flag_russia"></use>
                    </svg>
                </span>
                RU
            </a>

            <a href="javascript:void(0)" class="b-button b-button_primary b-header__burger">
                <svg>
                    <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#burger"></use>
                </svg>
            </a>
        </div>
    </div>
</header>
<main class="b-main b-main_centered">

    <?php Robot\Core\Tools\Template\Helper::showTitle() ?>