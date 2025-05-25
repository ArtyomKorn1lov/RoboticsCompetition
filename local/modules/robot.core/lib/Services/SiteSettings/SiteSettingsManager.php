<?php

namespace Robot\Core\Services\SiteSettings;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsUpdate;
use Robot\Core\Repositories\SiteSettings\SiteSettingsRepository;
use Robot\Core\Tools\Files\Helper;
use Robot\Core\Tools\Mappers\SiteSettings;
use Robot\Core\Entity\SiteSettings\SiteSettingsUpdate as SiteSettingsUpdateEntity;
use Robot\Core\Constants;

Loc::loadMessages(__FILE__);

class SiteSettingsManager implements ISiteSettingsManager
{
    /**
     * @param string $siteId
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getSiteSettingsEdit(string $siteId): array
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsRepository = new SiteSettingsRepository();

            $data = $siteSettingsRepository->getSiteSettingsEdit($siteId);

            // TODO заменить через сервис-локатор
            $fileHelper = new Helper();
            !empty($data["LOGO"]) && $data["LOGO"] = $fileHelper->getFilePath($data["LOGO"]);
            !empty($data["LOGO_FOOTER"]) && $data["LOGO_FOOTER"] = $fileHelper->getFilePath($data["LOGO_FOOTER"]);

            if (empty($data)) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_NOT_FOUND"));
            }

            return $data;
        } catch (ArgumentException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @return SiteSettingsHeader
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getSettingsHeader(): SiteSettingsHeader
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsRepository = new SiteSettingsRepository();
            $arSiteSetting = $siteSettingsRepository->getSiteSettingsHeader();
            if (empty($arSiteSetting)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
            }
            $siteSetting = SiteSettings::mapSiteSettingHeaderResponseToModel($arSiteSetting);
            // TODO заменить через сервис-локатор
            $fileHelper = new Helper();
            !empty($siteSetting->logo) && $siteSetting->logo = $fileHelper->getFilePath($siteSetting->logo);
            return $siteSetting;
        } catch (SystemException|ArgumentException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @return SiteSettingsFooter
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getSettingsFooter(): SiteSettingsFooter
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsRepository = new SiteSettingsRepository();
            $arSiteSetting = $siteSettingsRepository->getSiteSettingsFooter();
            if (empty($arSiteSetting)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
            }
            $siteSetting = SiteSettings::mapSiteSettingsFooterResponseToModel($arSiteSetting);
            // TODO заменить через сервис-локатор
            $fileHelper = new Helper();
            !empty($siteSetting->logoFooter) && $siteSetting->logoFooter = $fileHelper->getFilePath($siteSetting->logoFooter);
            !empty($siteSetting->email) && $siteSetting->email = $this->getArrayField($siteSetting->email);
            !empty($siteSetting->phone) && $siteSetting->phone = $this->getArrayField($siteSetting->phone);
            return $siteSetting;
        } catch (SystemException|ArgumentException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @return SiteSettingsContacts
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getSettingContacts(): SiteSettingsContacts
    {
        try {
            // TODO заменить через сервис-локатор
            $siteSettingsRepository = new SiteSettingsRepository();
            $arSiteSetting = $siteSettingsRepository->getSiteSettingsContacts();
            if (empty($arSiteSetting)) {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
            }
            $siteSetting = SiteSettings::mapSiteSettingsContactsResponseToModel($arSiteSetting);
            !empty($siteSetting->email) && $siteSetting->email = $this->getArrayField($siteSetting->email);
            !empty($siteSetting->phone) && $siteSetting->phone = $this->getArrayField($siteSetting->phone);
            return $siteSetting;
        } catch (SystemException|ArgumentException|ObjectPropertyException $exception) {
            AddMessage2Log($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param SiteSettingsUpdate $siteSettingsUpdate
     * @return void
     * @throws ArgumentException
     * @throws ObjectException
     * @throws SystemException
     */
    public function saveSiteSettings(SiteSettingsUpdate $siteSettingsUpdate, string $siteId): void
    {
        try {
            if (empty($siteSettingsUpdate)) {
                throw new ObjectException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_UPDATE_EMPTY"));
            }

            $entity = new SiteSettingsUpdateEntity($siteSettingsUpdate->id, $siteSettingsUpdate->arSiteSettings, $siteId);
            
            // TODO заменить через сервис-локатор
            $siteSettingsRepository = new SiteSettingsRepository();
            $siteSettingsRepository->saveSiteSettings($entity);
        } catch (SystemException $exception) {
            AddMessage2Log($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param string $lang
     * @return string
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getSiteIdByLang(string $lang): string
    {
        try {
            if (empty($lang)) {
                $lang = Constants::LANG_RUSSIA_CODE;
            }

            // TODO заменить через сервис-локатор
            $siteSettingsRepository = new SiteSettingsRepository();
            return $siteSettingsRepository->getSiteIdByLang($lang);
        } catch (SystemException|ObjectPropertyException|ArgumentException $exception) {
            AddMessage2Log($exception->getMessage());
            throw $exception;
        }
    }

    /**
     * @param string $field
     * @return array
     */
    protected function getArrayField(string $field): array
    {
        $array = explode(",", $field);
        foreach ($array as $key => $item) {
            $array[$key] = trim($item);
        }
        return $array;
    }
}