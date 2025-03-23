<?php

namespace Robot\Core\Tools\Template;

class Helper
{
    /** @var string Относительный путь к иконке в файловой системе */
    protected const SPRITE_FOLDER_PATH = SITE_DIR . "local/templates/robot/app/dist/assets/icons/sprite.svg#";

    /** @var string Код свойства для хранения заголовка в буфере */
    protected const TITLE_VIEW_CONTENT_CODE = "PAGER_TITLE";

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

    /**
     * @param string $class
     * @return void
     */
    public static function initTitle(string $class = ''): void
    {
        global $APPLICATION;

        $html = "";
        if ($APPLICATION->GetPageProperty("SHOW_TITLE", "Y") === "Y") {
            $html = "<h1 class=\"{$class}\">" . $APPLICATION->GetTitle(false, true) . "</h1>";
        }

        $APPLICATION->AddViewContent(static::TITLE_VIEW_CONTENT_CODE, $html);
    }

    /**
     * @return void
     */
    public static function showTitle(): void
    {
        global $APPLICATION;
        $APPLICATION->ShowViewContent(static::TITLE_VIEW_CONTENT_CODE);
    }
}