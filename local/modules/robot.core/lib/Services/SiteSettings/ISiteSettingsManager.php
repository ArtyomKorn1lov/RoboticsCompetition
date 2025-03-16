<?php

namespace Robot\Core\Services\SiteSettings;

use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;
use Robot\Core\DTO\SiteSettings\SiteSettingsUpdate;

interface ISiteSettingsManager
{
    /**
     * @return int
     */
    public function getSiteSettingsEdit(string $siteId): array;

    /**
     * @return SiteSettingsHeader
     */
    public function getSettingsHeader(): SiteSettingsHeader;

    /**
     * @return SiteSettingsFooter
     */
    public function getSettingsFooter(): SiteSettingsFooter;

    /**
     * @return SiteSettingsContacts
     */
    public function getSettingContacts(): SiteSettingsContacts;

    public function saveSiteSettings(SiteSettingsUpdate $siteSettingsUpdate): void;
}