<?php

namespace Robot\Core\Tools\Modules;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Application;

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
}