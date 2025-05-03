<?php

namespace Robot\Core\Services\SiteSettings;

use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;
use Robot\Core\DTO\SiteSettings\SiteSettingsUpdate;

interface ISiteSettingsManager
{
    /**
     * @param string $siteId
     * @return array
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

    /**
     * @param SiteSettingsUpdate $siteSettingsUpdate
     * @return void
     */
    public function saveSiteSettings(SiteSettingsUpdate $siteSettingsUpdate): void;

    /**
     * @param string $lang
     * @return string
     */
    public function getSiteIdByLang(string $lang): string;
}