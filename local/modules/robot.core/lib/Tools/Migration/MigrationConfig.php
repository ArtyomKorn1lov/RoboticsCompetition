<?php

namespace Robot\Core\Tools\Migration;

class MigrationConfig
{
    /**
     * @return string
     */
    public static function getConfigDirectory(): string
    {
        return __DIR__;
    }

    /**
     * @return array
     */
    public static function getConfig(): array
    {
        return require self::getConfigDirectory() . '/migrations.core.php';
    }
}