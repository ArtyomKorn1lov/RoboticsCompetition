<?php

namespace Robot\Core\DTO\SiteSettings;

final class SiteSettingsContacts
{
    /**
     * @param array $addressOrganisation
     * @param array $contactPhones
     * @param string|array|null $email
     * @param array $socialNetworks
     * @param array $coords
     */
    public function __construct(
        public array $addressOrganisation,
        public array $contactPhones,
        public string|array|null $email,
        public array $socialNetworks,
        public array $coords
    )
    {
    }
}