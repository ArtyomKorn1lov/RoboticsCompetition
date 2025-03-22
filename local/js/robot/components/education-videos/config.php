<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

return [
    'css' => './dist/styles.bundle.css',
    'js' => './dist/script.bundle.js',
    'rel' => [
        'robot.core',
        'robot.ui',
        'robot.tools',
        'robot.components.media-popup'
    ],
    'skip_core' => true,
];
