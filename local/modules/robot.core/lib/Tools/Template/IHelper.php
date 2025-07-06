<?php

namespace Robot\Core\Tools\Template;

interface IHelper
{
    /**
     * @param string $code
     * @param string $class
     * @return string
     */
    public static function getIcon(string $code, string $class = ""): string;

    /**
     * @param string $class
     * @return void
     */
    public static function initTitle(string $class = ''): void;

    /**
     * @return void
     */
    public static function showTitle(): void;
}