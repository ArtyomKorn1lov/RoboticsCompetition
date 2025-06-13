<?php

namespace Robot\Core\Tools\Template;

use Bitrix\Main\Localization\Loc;

use Robot\Core\Constants;
use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\Enums\YaMapLang;

class Helper implements IHelper
{
    /** @var string Относительный путь к иконке в файловой системе */
    protected const SPRITE_FOLDER_PATH = "/local/templates/robot/app/dist/assets/icons/sprite.svg#";

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

    /**
     * @return string
     */
    public static function buildYandexApiUrl(): string
    {
        $mapLang = Loc::getCurrentLang() === Constants::LANG_ENGLISH_CODE ? YaMapLang::en->value : YaMapLang::ru->value;
        return $_ENV['YA_MAP_API_URL']."?lang=".$mapLang;
    }

    /**
     * @param string $title
     * @return string|bool
     */
    public static function getBallonHeader(string $title): string|bool
    {
        if (empty($title)) {
            return '';
        }
        return "<h6>$title</h6>";
    }

    /**
     * @param SiteSettingsContacts $contacts
     * @return string|bool
     */
    public static function getBallonBody(SiteSettingsContacts $contacts): string|bool
    {
        if (empty($contacts)) {
            return '';
        }

        $html = '<div class="b-map__content">';

        if (!empty($contacts->email)) {
            foreach ($contacts->email as $item) {
                $html = $html . '<a class="b-map__item b-map__item_mail" href="mailto:'.$item.'">'.$item.'</a>';
            }
        }

        if (!empty($contacts->phone)) {
            foreach ($contacts->phone as $item) {
                $html = $html . '<a class="b-map__item b-map__item_phone" href="tel:'.static::convertPhoneTelFormat($item).'">'.$item.'</a>';
            }
        }

        if (!empty($contacts->address)) {
            $html = $html . '<span class="b-map__item b-map__item_address">'.$contacts->address.'</span>';
        }

        return $html."</div>";
    }
}