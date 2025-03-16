<?php

namespace Robot\Core\DTO\SiteSettings;

final class SiteSettingsContacts
{
    /**
     * @param string $address
     * @param array $addressOrganisation
     * @param array $contactPhones
     * @param string|array|null $email
     * @param array $socialNetworks
     * @param array $coords
     */
    public function __construct(
        public string $address,
        public array $addressOrganisation,
        public array $contactPhones,
        public string|array|null $email,
        public array $socialNetworks,
        public array $coords
    )
    {
    }
}