<?php

namespace Robot\Core\Tools\Modules;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Application;

use CSite;
use Exception;

class Manager implements IManager
{
    /** @var string путь к файлам модуля в upload */
    public const MODULE_FILE_PATH = '/robot.core/';

    /** @var string путь статике для настроек сайта */
    public const SITE_SETTINGS_FILE_PATH = self::MODULE_FILE_PATH."settings/";

    /** @var string относительный путь к frontend'у на vue */
    public const FRONTEND_VUE_RELATIVE_PATH = "/js/robot";

    /** @var string относительный путь к шаблону сайта */
    public const TEMPLATE_RELATIVE_PATH = "/templates/robot";

    /** @var string относительный путь к компонентам модуля */
    public const COMPONENTS_RELATIVE_PATH = "/components/robot";

    /** @var string публичные файлы модуля */
    public const PUBLIC_RELATIVE_PATH = "/public";

    /** @var string имя файла с логотипом в шапке сайта */
    public const DEFAULT_LOGO_FILENAME = "logo.svg";

    /** @var string имя файла с логотипом в подвале сайта */
    public const DEFAULT_LOGO_FOOTER_FILENAME = "logo_footer.svg";

    /** @var string папка обычного frontend'а на vue */
    public const FRONTEND_PLUGINS_FOLDER = "app";

    /**
     * @param string[] $modules
     * @return void
     * @throws LoaderException
     */
    public static function requireModules(array $modules): void
    {
        foreach ($modules as $module) {
            Loader::requireModule($module);
        }
    }

    /**
     * @return bool
     */
    public static function includeFrontendPlugins(): bool
    {
        $pluginPath = Application::getDocumentRoot() . SITE_TEMPLATE_PATH . "/" . static::FRONTEND_PLUGINS_FOLDER . "/plugins.php";
        return file_exists($pluginPath) && @require($pluginPath);
    }

    /**
     * @param string $siteId
     * @param string $lang
     * @param array $siteData
     * @return void
     * @throws Exception
     */
    public static function updateSiteParams(string $siteId, string $lang, array $siteData): void
    {
        $obSite = new CSite();
        $result = $obSite->update($siteId, [
            "ACTIVE" => "Y",
            "SORT" => $siteData["SORT"],
            "NAME" => $siteData["NAME"],
            "DEF"  => $siteData["DEF"],
            "DIR" => $siteData["DIR"],
            "FORMAT_DATE" => $siteData["FORMAT_DATE"],
            "FORMAT_DATETIME" => $siteData["FORMAT_DATETIME"],
            "FORMAT_NAME" => $siteData["FORMAT_NAME"],
            "WEEK_START" => $siteData["WEEK_START"],
            "CHARSET" => $siteData["CHARSET"],
            "LANGUAGE_ID" => $lang,
            "DOMAIN_LIMITED"  => $siteData["DOMAIN_LIMITED"],
            "SERVER_NAME"   => $siteData["SERVER_NAME"],
            "SITE_NAME" =>  $siteData["SITE_NAME"],
            "TEMPLATE" => [
                [
                    'CONDITION' => "",
                    'SORT' => 150,
                    'TEMPLATE' => "robot"
                ]
            ]
        ]);
        if (!$result) {
            throw new Exception("Ошибка обновления сайта " . $siteId);
        }
    }
}