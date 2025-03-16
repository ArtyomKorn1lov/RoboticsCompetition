<?php

namespace Robot\Core\Repositories\SiteSettings;

use Robot\Core\Entity\SiteSettings\SiteSettingsUpdate;

interface ISiteSettingsRepository
{
    /**
     * @return int
     */
    public function getSiteSettingsEdit(string $siteId): array;

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

    /**
     * @param SiteSettingsUpdate $entity
     * @return void
     */
    public function saveSiteSettings(SiteSettingsUpdate $entity): void;
}