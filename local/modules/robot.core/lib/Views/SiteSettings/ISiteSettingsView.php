<?php

namespace Robot\Core\Views\SiteSettings;

use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;

interface ISiteSettingsView
{
    /**
     * @return SiteSettingsHeader|bool
     */
    public static function getSettingsHeader(): SiteSettingsHeader|bool;

    /**
     * @return SiteSettingsFooter|bool
     */
    public static function getSettingsFooter(): SiteSettingsFooter|bool;
}