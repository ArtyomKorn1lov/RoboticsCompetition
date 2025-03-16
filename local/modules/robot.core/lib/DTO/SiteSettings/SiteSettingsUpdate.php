<?php

namespace Robot\Core\DTO\SiteSettings;

final class SiteSettingsUpdate
{
    public function __construct(
        public int $id,
        public array $arSiteSettings
    )
    {
    }
}