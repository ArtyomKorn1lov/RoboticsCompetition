<?php

namespace Robot\Core\Tools\Modules;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;

class Manager
{
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