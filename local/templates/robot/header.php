<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);

global $APPLICATION;

if (!Bitrix\Main\Loader::includeModule('robot.core')) {
    ShowError('Ошибка! Не подключен модуль ядра сайта.');
    die();
}
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
<header>
    <div id="panel"><?php $APPLICATION->ShowPanel(); ?></div>

    <!-- Логотип -->
    <a href="<?=SITE_DIR?>">
        <img width="150" src="<?=SITE_DIR?>local/templates/robot/app/img/logo.webp" alt="logo">
    </a>
    <!-- !Логотип -->

    <!-- Название сайта -->
    <h1>
        Соревнования робототехники в ПГТУ
    </h1>
    <!-- !Название сайта -->

    <!-- Главное меню -->
    <?php $APPLICATION->IncludeComponent(
    "bitrix:menu",
    ".default",
    array(
		"ROOT_MENU_TYPE" => "top",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "top",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "Y",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => ""
	    )
    );?>
    <!-- !Главное меню -->
</header>
<main>

    <?php if ($APPLICATION->GetCurPage(false) !== "/") { ?>
        <h1>
            <?php $APPLICATION->ShowTitle(false) ?>
        </h1>
    <?php } ?>