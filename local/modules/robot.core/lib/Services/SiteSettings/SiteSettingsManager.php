<?php

namespace Robot\Core\Services\SiteSettings;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;
use Robot\Core\DTO\SiteSettings\SiteSettingsContacts;
use Robot\Core\DTO\SiteSettings\SiteSettingsHeader;
use Robot\Core\DTO\SiteSettings\SiteSettingsFooter;
use Robot\Core\DTO\SiteSettings\SiteSettingsUpdate;
use Robot\Core\Exceptions\RobotException;
use Robot\Core\Logger\Logger;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Repositories\SiteSettings\ISiteSettingsRepository;
use Robot\Core\Tools\Files\IHelper;
use Robot\Core\Tools\Mappers\SiteSettings;
use Robot\Core\Entity\SiteSettings\SiteSettingsUpdate as SiteSettingsUpdateEntity;
use Robot\Core\Constants;

Loc::loadMessages(__FILE__);

class SiteSettingsManager implements ISiteSettingsManager
{
    /** @var ISiteSettingsRepository репозиторий настройки для сайта */
    private ISiteSettingsRepository $siteSettingsRepository;
    /** @var IHelper хелпер для работы с файлами */
    private IHelper $fileHelper;
    /** @var Logger объект логирования */
    private Logger $logger;

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $serviceLocator = ServiceLocator::getInstance();
        $this->siteSettingsRepository = $serviceLocator->get(ISiteSettingsRepository::class);
        $this->fileHelper = $serviceLocator->get(IHelper::class);
        $this->logger = LoggerFactory::build();
    }

    /**
     * @param string $siteId
     * @return array
     * @throws RobotException
     * @throws SystemException
     */
    public function getSiteSettingsEdit(string $siteId): array
    {
        try {
            $data = $this->siteSettingsRepository->getSiteSettingsEdit($siteId);

            !empty($data["LOGO"]) && $data["LOGO"] = $this->fileHelper->getFilePath($data["LOGO"]);
            !empty($data["LOGO_FOOTER"]) && $data["LOGO_FOOTER"] = $this->fileHelper->getFilePath($data["LOGO_FOOTER"]);

            if (empty($data)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_NOT_FOUND"));
            }

            return $data;
        } catch (RobotException $exception) {
            throw $exception;
        } catch (SystemException $exception) {
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @return SiteSettingsHeader
     * @throws RobotException
     * @throws SystemException
     */
    public function getSettingsHeader(): SiteSettingsHeader
    {
        try {
            $arSiteSetting = $this->siteSettingsRepository->getSiteSettingsHeader();
            if (empty($arSiteSetting)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
            }
            $siteSetting = SiteSettings::mapSiteSettingHeaderResponseToModel($arSiteSetting);
            !empty($siteSetting->logo) && $siteSetting->logo = $this->fileHelper->getFilePath($siteSetting->logo);
            return $siteSetting;
        } catch (RobotException $exception) {
            throw $exception;
        } catch (SystemException $exception) {
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @return SiteSettingsFooter
     * @throws RobotException
     * @throws SystemException
     */
    public function getSettingsFooter(): SiteSettingsFooter
    {
        try {
            $arSiteSetting = $this->siteSettingsRepository->getSiteSettingsFooter();
            if (empty($arSiteSetting)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
            }
            $siteSetting = SiteSettings::mapSiteSettingsFooterResponseToModel($arSiteSetting);
            !empty($siteSetting->logoFooter) && $siteSetting->logoFooter = $this->fileHelper->getFilePath($siteSetting->logoFooter);
            !empty($siteSetting->email) && $siteSetting->email = $this->getArrayField($siteSetting->email);
            !empty($siteSetting->phone) && $siteSetting->phone = $this->getArrayField($siteSetting->phone);
            return $siteSetting;
        } catch (RobotException $exception) {
            throw $exception;
        } catch (SystemException $exception) {
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @return SiteSettingsContacts
     * @throws RobotException
     * @throws SystemException
     */
    public function getSettingContacts(): SiteSettingsContacts
    {
        try {
            $arSiteSetting = $this->siteSettingsRepository->getSiteSettingsContacts();
            if (empty($arSiteSetting)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
            }
            $siteSetting = SiteSettings::mapSiteSettingsContactsResponseToModel($arSiteSetting);
            !empty($siteSetting->email) && $siteSetting->email = $this->getArrayField($siteSetting->email);
            !empty($siteSetting->phone) && $siteSetting->phone = $this->getArrayField($siteSetting->phone);
            return $siteSetting;
        } catch (RobotException $exception) {
            throw $exception;
        } catch (SystemException $exception) {
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @param SiteSettingsUpdate $siteSettingsUpdate
     * @param string $siteId
     * @return void
     * @throws RobotException
     * @throws SystemException
     */
    public function saveSiteSettings(SiteSettingsUpdate $siteSettingsUpdate, string $siteId): void
    {
        try {
            if (empty($siteSettingsUpdate)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_UPDATE_EMPTY"));
            }

            $entity = new SiteSettingsUpdateEntity($siteSettingsUpdate->id, $siteSettingsUpdate->arSiteSettings, $siteId);

            $this->siteSettingsRepository->saveSiteSettings($entity);
        } catch (RobotException $exception) {
            throw $exception;
        } catch (SystemException $exception) {
            $this->logger->error($exception);
            throw $exception;
        }
    }

    /**
     * @param string $lang
     * @return string
     * @throws RobotException
     * @throws SystemException
     */
    public function getSiteIdByLang(string $lang): string
    {
        try {
            if (empty($lang)) {
                $lang = Constants::LANG_RUSSIA_CODE;
            }

            return $this->siteSettingsRepository->getSiteIdByLang($lang);
        } catch (RobotException $exception) {
            throw $exception;
        } catch (SystemException $exception) {
            $this->logger->error($exception);
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