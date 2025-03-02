<?php

namespace Robot\Core\Views\SiteSettings;

use Bitrix\Main\SystemException;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;
use Robot\Core\Services\SiteSettings\SiteSettingsManager;

class SiteSettingsView implements ISiteSettingsView
{
    /**
     * @return SiteSettingsHeader|bool
     */
    public static function getSettingsHeader(): SiteSettingsHeader|bool
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsManager = new SiteSettingsManager();
            return $siteSettingsManager->getSettingsHeader();
        } catch (SystemException $exception) {
            AddMessage2Log($exception->getMessage());
            return false;
        }
    }

    /**
     * @return SiteSettingsFooter|bool
     */
    public static function getSettingsFooter(): SiteSettingsFooter|bool
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsManager = new SiteSettingsManager();
            return $siteSettingsManager->getSettingsFooter();
        } catch (SystemException $exception) {
            AddMessage2Log($exception->getMessage());
            return false;
        }
    }
}