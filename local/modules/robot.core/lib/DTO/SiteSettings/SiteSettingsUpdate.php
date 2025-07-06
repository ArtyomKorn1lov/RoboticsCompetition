<?php

namespace Robot\Core\DTO\SiteSettings;

final class SiteSettingsUpdate
{
    /**
     * @param int $id
     * @param array $arSiteSettings
     */
    public function __construct(
        public int $id,
        public array $arSiteSettings
    )
    {
    }
}