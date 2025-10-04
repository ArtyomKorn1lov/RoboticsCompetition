<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

require dirname(__DIR__, 2) . "/vendor/autoload.php";

/*use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;

use Robot\Core\Tools\Events\HighloadBlocksEventHandler;
use Robot\Core\Entity\Event\RegistrationFieldsTable;

Loader::includeModule("highloadblock");
Loader::includeModule("robot.core");

$event = EventManager::getInstance();

$event->addEventHandler(
    '',
    "RegistrationFieldsOnAfterAdd",
    ['Robot\\Core\\Tools\\Events\\HighloadBlocksEventHandler', 'onAfterChange']
);

$event->addEventHandler(
    '',
    "RegistrationFieldsOnAfterUpdate",
    ['Robot\\Core\\Tools\\Events\\HighloadBlocksEventHandler', 'onAfterChange']
);

$event->addEventHandler(
    '',
    "RegistrationFieldsOnAfterDelete",
    ['Robot\\Core\\Tools\\Events\\HighloadBlocksEventHandler', 'onAfterChange']
);*/