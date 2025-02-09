<?php

namespace Robot\Core\Tools\Template;

class Helper
{
    /** @var string Отностельный путь к иконке в файловой системе */
    protected const SPRITE_FOLDER_PATH = SITE_DIR . "local/templates/robot/app/dist/assets/icons/sprite.svg#";

    /**
     * @param string $code
     * @param string $class
     * @return string
     */
    public static function getIcon(string $code, string $class = ""): string
    {
        return '<svg class="'.$class.'"><use xlink:href="' . static::SPRITE_FOLDER_PATH . $code . '"></use></svg>';
    }

    /**
     * @param string $phone
     * @return string
     */
    public static function convertPhoneTelFormat(string $phone): string
    {
        return preg_replace("/[^\d]+/s", "", $phone);
    }
}