<?php

namespace Robot\Core\Services\SiteSettings;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;
use Robot\Core\Cache\ICacheService;
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
    /** @var ICacheService сервис кэширования */
    private ICacheService $cacheService;
    /** @var IHelper хелпер для работы с файлами */
    private IHelper $fileHelper;
    /** @var Logger объект логирования */
    private Logger $logger;

    /** @var string уникальный ключ кэша */
    protected const SITE_SETTINGS_HEADER_CACHE_KEY = 'robot_core_cache_site_settings_header_key';
    /** @var string путь к кэшу */
    protected const SITE_SETTINGS_HEADER_CACHE_PATH = 'site.settings/header';

    /** @var string уникальный ключ кэша */
    protected const SITE_SETTINGS_FOOTER_CACHE_KEY = 'robot_core_cache_site_settings_footer_key';
    /** @var string путь к кэшу */
    protected const SITE_SETTINGS_FOOTER_CACHE_PATH = 'site.settings/footer';

    /** @var string уникальный ключ кэша */
    protected const SITE_SETTINGS_CONTACTS_CACHE_KEY = 'robot_core_cache_site_settings_contacts_key';
    /** @var string путь к кэшу */
    protected const SITE_SETTINGS_CONTACTS_CACHE_PATH = 'site.settings/contacts';

    /**
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        $serviceLocator = ServiceLocator::getInstance();
        $this->siteSettingsRepository = $serviceLocator->get(ISiteSettingsRepository::class);
        $this->cacheService = $serviceLocator->get(ICacheService::class);
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
            if ($this->cacheService->init(self::SITE_SETTINGS_HEADER_CACHE_KEY, self::SITE_SETTINGS_HEADER_CACHE_PATH)) {
                /** @var SiteSettingsHeader $siteSetting */
                $siteSetting = $this->cacheService->getData();
                return $siteSetting;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::SITE_SETTINGS_HEADER_CACHE_PATH);

                $arSiteSetting = $this->siteSettingsRepository->getSiteSettingsHeader();
                if (empty($arSiteSetting)) {
                    throw new RobotException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
                }
                $siteSetting = SiteSettings::mapSiteSettingHeaderResponseToModel($arSiteSetting);
                !empty($siteSetting->logo) && $siteSetting->logo = $this->fileHelper->getFilePath($siteSetting->logo);

                $this->cacheService->registerTag(Constants::SITE_SETTINGS_HEADER_TAG_CACHE);
                $this->cacheService->endTag();
                $this->cacheService->end($siteSetting);
                return $siteSetting;
            } else {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_CACHE", ["#PATH#" => self::SITE_SETTINGS_HEADER_CACHE_PATH]));
            }
        } catch (RobotException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            throw $exception;
        } catch (SystemException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
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
            if ($this->cacheService->init(self::SITE_SETTINGS_FOOTER_CACHE_KEY, self::SITE_SETTINGS_FOOTER_CACHE_PATH)) {
                /** @var SiteSettingsFooter $siteSetting */
                $siteSetting = $this->cacheService->getData();
                return $siteSetting;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::SITE_SETTINGS_FOOTER_CACHE_PATH);

                $arSiteSetting = $this->siteSettingsRepository->getSiteSettingsFooter();
                if (empty($arSiteSetting)) {
                    throw new RobotException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
                }
                $siteSetting = SiteSettings::mapSiteSettingsFooterResponseToModel($arSiteSetting);
                !empty($siteSetting->logoFooter) && $siteSetting->logoFooter = $this->fileHelper->getFilePath($siteSetting->logoFooter);
                !empty($siteSetting->email) && $siteSetting->email = $this->getArrayField($siteSetting->email);
                !empty($siteSetting->phone) && $siteSetting->phone = $this->getArrayField($siteSetting->phone);

                $this->cacheService->registerTag(Constants::SITE_SETTINGS_FOOTER_TAG_CACHE);
                $this->cacheService->endTag();
                $this->cacheService->end($siteSetting);
                return $siteSetting;
            } else {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_CACHE", ["#PATH#" => self::SITE_SETTINGS_FOOTER_CACHE_PATH]));
            }
        } catch (RobotException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            throw $exception;
        } catch (SystemException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
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
            if ($this->cacheService->init(self::SITE_SETTINGS_CONTACTS_CACHE_KEY, self::SITE_SETTINGS_CONTACTS_CACHE_PATH)) {
                /** @var SiteSettingsContacts $siteSetting */
                $siteSetting = $this->cacheService->getData();
                return $siteSetting;
            } elseif ($this->cacheService->start()) {
                $this->cacheService->startTag(self::SITE_SETTINGS_CONTACTS_CACHE_PATH);

                $arSiteSetting = $this->siteSettingsRepository->getSiteSettingsContacts();
                if (empty($arSiteSetting)) {
                    throw new RobotException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_ITEM_NOT_FOUND"));
                }
                $siteSetting = SiteSettings::mapSiteSettingsContactsResponseToModel($arSiteSetting);
                !empty($siteSetting->email) && $siteSetting->email = $this->getArrayField($siteSetting->email);
                !empty($siteSetting->phone) && $siteSetting->phone = $this->getArrayField($siteSetting->phone);

                $this->cacheService->registerTag(Constants::SITE_SETTINGS_CONTACTS_TAG_CACHE);
                $this->cacheService->endTag();
                $this->cacheService->end($siteSetting);
                return $siteSetting;
            } else {
                throw new SystemException(Loc::getMessage("ROBOT_CORE_SITE_SETTINGS_CACHE", ["#PATH#" => self::SITE_SETTINGS_CONTACTS_CACHE_PATH]));
            }
        } catch (RobotException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
            throw $exception;
        } catch (SystemException $exception) {
            $this->cacheService->abortTag();
            $this->cacheService->abort();
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

            /** Очистка кэша контактной информации после изменения */
            $this->clearCache();
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

    /**
     * @return void
     */
    protected function clearCache(): void
    {
        $this->cacheService->clearTag(Constants::SITE_SETTINGS_HEADER_TAG_CACHE);
        $this->cacheService->clearTag(Constants::SITE_SETTINGS_FOOTER_TAG_CACHE);
        $this->cacheService->clearTag(Constants::SITE_SETTINGS_CONTACTS_TAG_CACHE);
    }
}