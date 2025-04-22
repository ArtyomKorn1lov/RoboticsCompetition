<?php

namespace Robot\Core\Tools\Mappers;

use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;
use Robot\Core\DTO\SiteSettings\SiteSettingsUpdate;

class SiteSettings
{
    /**
     * @param array $response
     * @return SiteSettingsHeader
     */
    public static function mapSiteSettingHeaderResponseToModel(array $response): SiteSettingsHeader
    {
        return new SiteSettingsHeader(
            siteName: $response["SITE_NAME"],
            logo: (int)$response["LOGO"]
        );
    }

    /**
     * @param array $response
     * @return SiteSettingsFooter
     */
    public static function mapSiteSettingsFooterResponseToModel(array $response): SiteSettingsFooter
    {
        return new SiteSettingsFooter(
            siteName: $response["SITE_NAME"],
            logoFooter: (int)$response["LOGO_FOOTER"],
            email: $response["EMAIL"],
            phone: $response["PHONE"],
            address: $response["ADDRESS"],
            socialNetworks: $response["SOCIAL_NETWORKS_FOOTER"]
        );
    }

    /**
     * @param array $response
     * @return SiteSettingsContacts
     */
    public static function mapSiteSettingsContactsResponseToModel(array $response): SiteSettingsContacts
    {
        return new SiteSettingsContacts(
            name: $response["NAME"],
            address: $response["ADDRESS"],
            addressOrganisation: $response["ADDRESS_ORGANISATION"],
            contactPhones: $response["CONTACT_PHONES"],
            email: $response["EMAIL"],
            phone: $response["PHONE"],
            socialNetworks: $response["SOCIAL_NETWORKS"],
            coords: $response["MAP_COORDINATES"]
        );
    }

    /**
     * @param array $arSiteSettings
     * @return SiteSettingsUpdate
     */
    public static function mapArraySiteSettingsUpdateToModel(int $id, array $arSiteSettings): SiteSettingsUpdate
    {
        return new SiteSettingsUpdate($id, $arSiteSettings);
    }
}