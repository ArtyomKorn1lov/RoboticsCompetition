<?php

namespace Robot\Core\DTO\SiteSettings;

final class SiteSettingsHeader
{
    /**
     * @param string $siteName
     * @param string|int|bool|null $logo
     */
    public function __construct(
        public string               $siteName,
        public string|int|bool|null $logo
    )
    {
    }
}