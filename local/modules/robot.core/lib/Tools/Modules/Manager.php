<?php

namespace Robot\Core\Tools\Modules;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Application;

class Manager
{
    public const MODULE_FILE_PATH = '/robot.core/';

    public const SITE_SETTINGS_FILE_PATH = self::MODULE_FILE_PATH."settings/";

    public const DEFAULT_LOGO_FILENAME = "logo.svg";

    public const DEFAULT_LOGO_FOOTER_FILENAME = "logo_footer.svg";

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
}