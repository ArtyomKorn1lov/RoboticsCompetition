<?php

namespace Robot\Core\Views\SiteSettings;

use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;

interface ISiteSettingsView
{
    /**
     * @param string $siteId
     * @return array|bool
     */
    public static function getSiteSettingsEdit(string $siteId): array|bool;

    /**
     * @return SiteSettingsHeader|bool
     */
    public static function getSettingsHeader(): SiteSettingsHeader|bool;

    /**
     * @return SiteSettingsFooter|bool
     */
    public static function getSettingsFooter(): SiteSettingsFooter|bool;

    /**
     * @return SiteSettingsContacts|bool
     */
    public static function getSettingsContacts(): SiteSettingsContacts|bool;

    /**
     * @param array $arSiteSettings
     * @return string|bool
     */
    public static function saveSiteSettings(int $id, array $arSiteSettings): string|bool;
}