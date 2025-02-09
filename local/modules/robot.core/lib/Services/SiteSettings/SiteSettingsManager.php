<?php

namespace Robot\Core\Services\SiteSettings;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

use Robot\Core\DTO\SiteSettingsHeader;
use Robot\Core\DTO\SiteSettingsFooter;
use Robot\Core\Repositories\SiteSettings\SiteSettingsRepository;
use Robot\Core\Tools\Files\Helper;
use Robot\Core\Tools\Mappers\SiteSettings;

class SiteSettingsManager
{
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
                throw new SystemException("Запись не найдена");
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
                throw new SystemException("Запись не найдена");
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