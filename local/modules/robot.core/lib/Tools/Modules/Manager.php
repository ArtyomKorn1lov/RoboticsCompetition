<?php

namespace Robot\Core\Tools\Modules;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;

class Manager
{
    public const MODULE_FILE_PATH = '/robot.core/';

    public const SITE_SETTINGS_FILE_PATH = self::MODULE_FILE_PATH."settings/";

    public const DEFAULT_LOGO_FILENAME = "logo.svg";

    public const DEFAULT_LOGO_FOOTER_FILENAME = "logo_footer.svg";

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
}