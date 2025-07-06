<?php

namespace Robot\Core\Tools\Modules;

interface IManager
{
    /**
     * @param array $modules
     * @return void
     */
    public static function requireModules(array $modules): void;

    /**
     * @return bool
     */
    public static function includeFrontendPlugins(): bool;
}