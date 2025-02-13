<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * Регистрация extention's для общих стилей, скриптов, плагинов, картинок и иконок
 */

$curDir = SITE_TEMPLATE_PATH ."/app/";

$distPath = $curDir . 'dist/';

$extentions = [
    "robot_frontend" => [
        "js" => $distPath . "js/main.min.js",
        "css" => $distPath . "css/style.min.css",
        "rel" => [],
        "use" => CJSCore::USE_PUBLIC,
    ],
    "jquery" => [
        "js" => $distPath . "js/jquery.js",
        "rel" => [],
        "use" => CJSCore::USE_PUBLIC,
    ]
];

foreach ($extentions as $code => $extention) {
    CJSCore::RegisterExt($code, $extention);
}

