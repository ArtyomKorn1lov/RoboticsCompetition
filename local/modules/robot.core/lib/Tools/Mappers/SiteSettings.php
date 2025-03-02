<?php

namespace Robot\Core\Tools\Mappers;

use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;

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
            socialNetworks: $response["SOCIAL_NETWORKS"]
        );
    }
}