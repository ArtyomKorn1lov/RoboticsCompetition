<?php

namespace Robot\Core\DTO\SiteSettings;

final class SiteSettingsFooter
{
    /**
     * @param string $siteName
     * @param string|int|bool|null $logoFooter
     * @param array|string|null $email
     * @param array|string|null $phone
     * @param string|null $address
     * @param array|null $socialNetworks
     */
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