<?php

namespace Robot\Core\Views\SiteSettings;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;
use Robot\Core\Services\SiteSettings\SiteSettingsManager;
use Robot\Core\Tools\Mappers\SiteSettings;

class SiteSettingsView implements ISiteSettingsView
{

    /**
     * @param string $siteId
     * @return array|bool
     */
    public static function getSiteSettingsEdit(string $siteId): array|bool
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsManager = new SiteSettingsManager();
            return $siteSettingsManager->getSiteSettingsEdit($siteId);
        } catch (SystemException $exception) {
            AddMessage2Log($exception->getMessage());
            return false;
        }
    }

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

    /**
     * @return SiteSettingsContacts|bool
     */
    public static function getSettingsContacts(): SiteSettingsContacts|bool
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsManager = new SiteSettingsManager();
            return $siteSettingsManager->getSettingContacts();
        } catch (SystemException $exception) {
            AddMessage2Log($exception->getMessage());
            return false;
        }
    }

    /**
     * @param int $id
     * @param array $arSiteSettings
     * @param string $siteId
     * @return string|bool
     */
    public static function saveSiteSettings(int $id, array $arSiteSettings, string $siteId): string|bool
    {
        try {
            if (empty($arSiteSettings)) {
                return true;
            }

            // TODO заменить через сервис-локатор
            $siteSettingsManager = new SiteSettingsManager();
            $siteSettingsManager->saveSiteSettings(SiteSettings::mapArraySiteSettingsUpdateToModel($id, $arSiteSettings), $siteId);
            return true;
        } catch (SystemException $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param string $lang
     * @return string|bool
     */
    public static function getSiteIdByLang(string $lang): string|bool
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsManager = new SiteSettingsManager();
            return $siteSettingsManager->getSiteIdByLang($lang);
        } catch (SystemException|ArgumentException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage());
            return false;
        }
    }
}