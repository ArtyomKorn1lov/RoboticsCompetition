<?php

namespace Robot\Core\Services\SiteSettings;

use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;

interface ISiteSettingsManager
{
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
}