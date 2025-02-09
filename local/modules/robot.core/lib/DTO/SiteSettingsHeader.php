<?php

namespace Robot\Core\DTO;

class SiteSettingsHeader
{
    public function __construct(
        public string               $siteName,
        public string|int|bool|null $logo
    )
    {
    }
}