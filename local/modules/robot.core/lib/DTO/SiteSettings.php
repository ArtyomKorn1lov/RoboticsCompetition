<?php

namespace Robot\Core\DTO;

class SiteSettings
{
    public function __construct(
        public string $siteName,
        public ?string $logo,
        public ?string $logoFooter,
        public ?array $email,
        public ?array $phone,
        public ?string $address,
        public ?array $socialNetworks
    )
    {
    }
}