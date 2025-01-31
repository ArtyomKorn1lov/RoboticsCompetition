<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * Автозагрузка классов psr-4
*/
if (
    is_file(__DIR__ . '/vendor/autoload.php')
    && !defined('COMPOSER_INITIALIZED')
) {
    require_once __DIR__ . '/vendor/autoload.php';
    @define('COMPOSER_INITIALIZED', true);
}
