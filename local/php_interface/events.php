<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

Loader::includeModule("iblock");

$eventManager = EventManager::getInstance();
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Site\\IBlock\\UserTypeTimeRange', 'GetUserTypeDescription']);