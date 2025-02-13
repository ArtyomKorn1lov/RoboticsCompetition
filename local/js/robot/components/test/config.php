<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

return [
    'css' => './dist/styles.bundle.css',
    'js' => './dist/script.bundle.js',
    'rel' => [
        'robot.core',
        'robot.components.test-card'
    ],
    'skip_core' => true,
];
