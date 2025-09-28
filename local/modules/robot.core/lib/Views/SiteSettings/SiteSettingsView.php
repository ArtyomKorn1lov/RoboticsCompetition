<?php

namespace Robot\Core\Views\SiteSettings;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;
use Robot\Core\Exceptions\RobotException;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Services\SiteSettings\ISiteSettingsManager;
use Robot\Core\Tools\Mappers\SiteSettings;

class SiteSettingsView
{

    /**
     * @param string $siteId
     * @return array|bool
     */
    public static function getSiteSettingsEdit(string $siteId): array|bool
    {
        try {
            /** @var ISiteSettingsManager $siteSettingsManager */
            $siteSettingsManager = ServiceLocator::getInstance()->get(ISiteSettingsManager::class);
            return $siteSettingsManager->getSiteSettingsEdit($siteId);
        } catch (RobotException $exception) {
            ShowError($exception->getMessage());
            return false;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            LoggerFactory::build()->error($exception);
            ShowError("Произошла внутренняя ошибка");
            return false;
        }
    }

    /**
     * @return SiteSettingsHeader|bool
     */
    public static function getSettingsHeader(): SiteSettingsHeader|bool
    {
        try {
            /** @var ISiteSettingsManager $siteSettingsManager */
            $siteSettingsManager = ServiceLocator::getInstance()->get(ISiteSettingsManager::class);
            return $siteSettingsManager->getSettingsHeader();
        } catch (RobotException $exception) {
            ShowError($exception->getMessage());
            return false;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            LoggerFactory::build()->error($exception);
            ShowError("Произошла внутренняя ошибка");
            return false;
        }
    }

    /**
     * @return SiteSettingsFooter|bool
     */
    public static function getSettingsFooter(): SiteSettingsFooter|bool
    {
        try {
            /** @var ISiteSettingsManager $siteSettingsManager */
            $siteSettingsManager = ServiceLocator::getInstance()->get(ISiteSettingsManager::class);
            return $siteSettingsManager->getSettingsFooter();
        } catch (RobotException $exception) {
            ShowError($exception->getMessage());
            return false;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            LoggerFactory::build()->error($exception);
            ShowError("Произошла внутренняя ошибка");
            return false;
        }
    }

    /**
     * @return SiteSettingsContacts|bool
     */
    public static function getSettingsContacts(): SiteSettingsContacts|bool
    {
        try {
            /** @var ISiteSettingsManager $siteSettingsManager */
            $siteSettingsManager = ServiceLocator::getInstance()->get(ISiteSettingsManager::class);
            return $siteSettingsManager->getSettingContacts();
        } catch (RobotException $exception) {
            ShowError($exception->getMessage());
            return false;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            LoggerFactory::build()->error($exception);
            ShowError("Произошла внутренняя ошибка");
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

            /** @var ISiteSettingsManager $siteSettingsManager */
            $siteSettingsManager = ServiceLocator::getInstance()->get(ISiteSettingsManager::class);
            $siteSettingsManager->saveSiteSettings(SiteSettings::mapArraySiteSettingsUpdateToModel($id, $arSiteSettings), $siteId);
            return true;
        } catch (RobotException $exception) {
            return $exception->getMessage();
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            LoggerFactory::build()->error($exception);
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
            /** @var ISiteSettingsManager $siteSettingsManager */
            $siteSettingsManager = ServiceLocator::getInstance()->get(ISiteSettingsManager::class);
            return $siteSettingsManager->getSiteIdByLang($lang);
        } catch (RobotException $exception) {
            ShowError($exception->getMessage());
            return false;
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            LoggerFactory::build()->error($exception);
            ShowError("Произошла внутренняя ошибка");
            return false;
        }
    }
}