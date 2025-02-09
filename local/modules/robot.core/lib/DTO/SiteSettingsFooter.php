<?php

namespace Robot\Core\DTO;

class SiteSettingsFooter
{
    public function __construct(
        public string               $siteName,
        public string|int|bool|null $logoFooter,
        public array|string|null    $email,
        public array|string|null    $phone,
        public ?string              $address,
        public ?array               $socialNetworks
    )
    {
    }
}