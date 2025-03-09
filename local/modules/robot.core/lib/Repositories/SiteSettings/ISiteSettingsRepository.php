<?php

namespace Robot\Core\Repositories\SiteSettings;

interface ISiteSettingsRepository
{
    /**
     * @return array
     */
    public function getSiteSettingsHeader(): array;

    /**
     * @return array
     */
    public function getSiteSettingsFooter(): array;

    /**
     * @return array
     */
    public function getSiteSettingsContacts(): array;
}