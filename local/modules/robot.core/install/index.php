<?php
//подключаем основные классы для работы с модулем
use Bitrix\Main\Application;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\InvalidOperationException;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\IO\File;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Config\Configuration;
use Bitrix\Main\EventManager;
use Bitrix\Main\Context;
use Bitrix\Main\LoaderException;

use Robot\Core\Tools\Modules\Manager;
use Robot\Core\Entity\SiteSettings\SiteSettingsTable;
use Robot\Core\Enums\SocialIcons;
use Robot\Core\Constants;
use Robot\Core\Tools\IBlocks\UserTypeTimeRange;
use Robot\Core\Tools\Migration\MigrationConfig;
use Robot\Core\Logger\Logger;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Tools\Events\HighloadBlocksEventHandler;

use Sprint\Migration\Installer;

Loc::loadMessages(__FILE__);

/**
 * В названии класса используется название директории модуля, только вместо точки ставим нижнее подчеркивание
 */
class robot_core extends CModule
{
    /** @var string корневая папка в которой находится модуль */
    private string $rootDir = BX_ROOT;

    /** @var array данные с формы 1-го шага */
    private array $stepData = [];
    private Logger $logger;

    /** @var array список подмодулей */
    private array $subModules = [
        "sprint.migration" => [
            "url" => "https://marketplace.1c-bitrix.ru/solutions/sprint.migration/",
            "name" => "Миграции для разработчиков",
        ],
        "asd.iblock" => [
            "url" => "https://marketplace.1c-bitrix.ru/solutions/asd.iblock/",
            "name" => "Информационные блоки, инструменты",
        ],
    ];

    public function __construct()
    {
        $arModuleVersion = array();
        /** Подключение версии модуля (файл будет следующим в списке) */
        include __DIR__ . '/version.php';
        /** Присваивание свойствам класса переменных из файла с версией модуля */
        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        /** Идентификатор модуля как и директории */
        $this->MODULE_ID = 'robot.core';
        /** Название модуля */
        $this->MODULE_NAME = Loc::getMessage('ROBOT_MODULE_NAME');
        /** Описание модуля */
        $this->MODULE_DESCRIPTION = Loc::getMessage('ROBOT_MODULE_DESCRIPTION');
        /** Используется ли индивидуальная схема распределения прав доступа, ставится N, так как не используется */
        $this->MODULE_GROUP_RIGHTS = 'N';
        /** Название компании партнера предоставляющей модуль */
        $this->PARTNER_NAME = Loc::getMessage('ROBOT_MODULE_PARTNER_NAME');
        /** Установка папки корневой директории - либо папка /bitrix либо /local */
        $this->setRootDir();
    }

    /**
     * Определение корневой папки для модуля, модуль находится в /local или в /bitrix
     * @return void
     */
    protected function setRootDir(): void
    {
        $path = getLocalPath('modules/'.$this->MODULE_ID.'/install/index.php');
        if (str_contains($path, '/local')) {
            $this->rootDir = '/local';
        }
    }

    /**
     * Проверка всех модулей, которые необходимы для работы текущего модуля
     * @return void
     * @throws LoaderException
     * @throws Exception
     */
    protected function checkSubModules(): void
    {
        foreach ($this->subModules as $key => $item) {
            if (!Loader::includeModule($key)) {
                throw new Exception(Loc::getMessage("ROBOT_SUBMODULE_NOT_INCLUDE", ["#NAME#" => $item["name"], "#URL#" => $item["url"]]));
            }
        }
    }

    /**
     * Валидация входных параметров первого шага формы
     * @param array $stepData
     * @return bool
     */
    protected function validateDataStep(array $stepData): bool
    {
        global $APPLICATION;
        if (empty($stepData["primarySiteId"])) {
            $APPLICATION->ThrowException(Loc::getMessage("ROBOT_MODULE_PRIMARY_SITE_EMPTY"));
            return false;
        }

        if (empty($stepData["secondarySiteId"])) {
            $APPLICATION->ThrowException(Loc::getMessage("ROBOT_MODULE_SECONDARY_SITE_EMPTY"));
            return false;
        }

        if ($stepData["primarySiteId"] === $stepData["secondarySiteId"]) {
            $APPLICATION->ThrowException(Loc::getMessage("ROBOT_MODULE_SITE_SIMILAR_ERROR"));
            return false;
        }

        if (!$this->checkSiteIsExist($stepData["primarySiteId"])) {
            $APPLICATION->ThrowException(Loc::getMessage("ROBOT_MODULE_PRIMARY_SITE_ERROR"));
            return false;
        }

        if (!$this->checkSiteIsExist($stepData["secondarySiteId"])) {
            $APPLICATION->ThrowException(Loc::getMessage("ROBOT_MODULE_SECONDARY_SITE_ERROR"));
            return false;
        }

        $this->stepData = $stepData;
        return true;
    }

    /**
     * Проверка существует ли сайт в системе
     * @param string $siteId
     * @return bool
     */
    protected static function checkSiteIsExist(string $siteId): bool
    {
        $rsObj = CSite::GetByID($siteId);
        $site = $rsObj->fetch();
        if (!$site) {
            return false;
        }
        return true;
    }

    /**
     * Установка модуля в системе
     * @return void
     */
    public function doInstall(): void
    {
        global $APPLICATION;
        try {
            $this->checkSubModules();

            $request = Context::getCurrent()->getRequest();
            $step = (int)$request->get('step');

            $validateSecondStep = false;
            if (!empty($step) && $step === 2) {
                $stepData = [
                    "defaultEmail" => $request->get('default_email'),
                    "primarySiteId" => $request->get('primary_site_id'),
                    "secondarySiteId" => $request->get('secondary_site_id'),
                    "isInstallMigrations" => $request->get('install_migrations'),
                ];
                $validateSecondStep = $this->validateDataStep($stepData);
            }

            if (!empty($step) && $step === 2 && $validateSecondStep) {
                ModuleManager::registerModule($this->MODULE_ID);
                Loader::includeModule($this->MODULE_ID);

                $this->logger = LoggerFactory::build();

                $this->installFiles();
                $this->installDb();
                $this->installRouting();
                $this->installEventHandlers();
                $this->installMigrations();
                Option::set($this->MODULE_ID, Constants::DEFAULT_RECIPIENT_EMAIL_OPTION_CODE, $this->stepData["defaultEmail"]);
                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INSTALL_TITLE_STEP_2'),
                    __DIR__ . '/step2.php'
                );
            } else {
                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('ROBOT_STEP1_TITLE'),
                    __DIR__ . '/step1.php'
                );
            }
        }
        catch (Exception $exception) {
            !empty($this->logger) && $this->logger->error($exception);
            ModuleManager::unRegisterModule($this->MODULE_ID);
            $APPLICATION->ThrowException($exception->getMessage());
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('ROBOT_STEP_ERROR_TITLE'),
                __DIR__ . '/installerror.php'
            );
        }
    }

    /**
     * Удаление модуля из системы
     * @return void
     */
    public function doUninstall(): void
    {
        global $APPLICATION;
        try {
            Loader::includeModule($this->MODULE_ID);
            $this->logger = LoggerFactory::build();
            $this->deleteImages();
            $this->unInstallDb();
            $this->unInstallFiles();
            $this->unInstallRouting();
            $this->unInstallEventHandlers();
            Option::delete($this->MODULE_ID);
            ModuleManager::unRegisterModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('ROBOT_DEINSTALL_TITLE'),
                __DIR__ . '/deinstalinfo.php'
            );
        } catch (Exception $exception) {
            !empty($this->logger) && $this->logger->error($exception);
            ModuleManager::unRegisterModule($this->MODULE_ID);
            $APPLICATION->ThrowException($exception->getMessage());
        }
    }

    /**
     * Установка файлов
     * @return void
     */
    public function installFiles(): void
    {
        $moduleUploadDir = Loader::getDocumentRoot() . '/upload' . Manager::MODULE_FILE_PATH;
        if (!Directory::isDirectoryExists($moduleUploadDir)) {
            Directory::createDirectory($moduleUploadDir);
        }
        $siteSettingsUploadDir = Loader::getDocumentRoot() . '/upload' . Manager::SITE_SETTINGS_FILE_PATH;
        if (!Directory::isDirectoryExists($siteSettingsUploadDir)) {
            Directory::createDirectory($siteSettingsUploadDir);
        }
        CopyDirFiles(__DIR__ . "/admin/robot_core_site_settings.php", Loader::getDocumentRoot() . BX_ROOT . "/admin/robot_core_site_settings.php");
        /** Статические файлы в режиме разработки не копируются */
        if ($_ENV['DEVELOP_MODE'] === "Y") {
            return;
        }
        /** Установка frontend'а на vue */
        CopyDirFiles(
            path_from: __DIR__ . Manager::FRONTEND_VUE_RELATIVE_PATH,
            path_to: Loader::getDocumentRoot() . $this->rootDir . Manager::FRONTEND_VUE_RELATIVE_PATH,
            Recursive: true
        );
        /** Установка шаблона сайта */
        CopyDirFiles(
            path_from: __DIR__ . Manager::TEMPLATE_RELATIVE_PATH,
            path_to: Loader::getDocumentRoot() . $this->rootDir . Manager::TEMPLATE_RELATIVE_PATH,
            Recursive: true
        );
        /** Установка компонентов модуля */
        CopyDirFiles(
            path_from: __DIR__ . Manager::COMPONENTS_RELATIVE_PATH,
            path_to: Loader::getDocumentRoot() . $this->rootDir . Manager::COMPONENTS_RELATIVE_PATH,
            Recursive: true
        );
        /** Установка публичных файлов модуля */
        CopyDirFiles(
            path_from: __DIR__ . Manager::PUBLIC_RELATIVE_PATH,
            path_to: Loader::getDocumentRoot() . '/',
            Recursive: true
        );
    }

    /**
     * Установка таблиц БД
     * @return false|void
     */
    public function installDb()
    {
        $connection = Application::getInstance()->getConnection();
        if (!$connection) {
            return false;
        }

        try {
            $connection->startTransaction();

            if (!$connection->isTableExists(SiteSettingsTable::getTableName())) {
                SiteSettingsTable::getEntity()->createDbTable();
            }

            $siteSettingsDir = __DIR__ . "\\assets\\";
            $siteSettingsUploadDir = Manager::SITE_SETTINGS_FILE_PATH;

            /** Установка настроек для основной версии сайта */
            $logo = CFile::MakeFileArray($siteSettingsDir . Manager::DEFAULT_LOGO_FILENAME);
            $logo = $logo ? CFile::SaveFile($logo, $siteSettingsUploadDir) : 0;
            $logoFooter = CFile::MakeFileArray($siteSettingsDir . Manager::DEFAULT_LOGO_FOOTER_FILENAME);
            $logoFooter = $logoFooter ? CFile::SaveFile($logoFooter, $siteSettingsUploadDir) : 0;
            Manager::updateSiteParams($this->stepData["primarySiteId"], "ru", [
                'ACTIVE' => 'Y',
                'SORT' => '1',
                'NAME' => 'Соревнования  по робототехнике в ПГТУ',
                'DEF' => 'Y',
                'DIR' => '/',
                'FORMAT_DATE' => 'DD.MM.YYYY',
                'FORMAT_DATETIME' => 'DD.MM.YYYY HH:MI:SS',
                'FORMAT_NAME' => '#NAME# #LAST_NAME#',
                'WEEK_START' => '1',
                'CHARSET' => 'UTF-8',
                'LANGUAGE_ID' => 'ru',
                'DOMAIN_LIMITED' => 'N',
                'SERVER_NAME' => '',
                'SITE_NAME' => 'Cайт для проведения соревнований по робототехнике',
            ]);
            SiteSettingsTable::add([
                "SITE_ID" => $this->stepData["primarySiteId"],
                "LANG" => "ru",
                "NAME" => "Поволжский государственный технологический университет",
                "EMAIL" => "info@volgatech.net",
                "PHONE" => '+7 (987) 654-32-10',
                "ADDRESS" => "Республика Марий Эл, г. Йошкар-Ола, площадь имени В.И. Ленина, 3",
                "ADDRESS_ORGANISATION" => [
                    "1 корпус:" => "Республика Марий Эл, г. Йошкар-Ола, площадь имени В.И. Ленина, 3",
                    "2 корпус:" => "Республика Марий Эл, г. Йошкар-Ола, ул. Советская, 158",
                    "3 корпус:" => "Республика Марий Эл, г. Йошкар-Ола, ул. Панфилова, 17",
                ],
                "CONTACT_PHONES" => [
                    "Приемная ректора:" => "(8362) 45-53-44",
                    "Отдел кадров:" => "(8362) 68-68-11",
                    "Бухгалтерия:" => "(8362) 68-78-97",
                ],
                "MAP_COORDINATES" => [
                    56.621796,
                    47.884858
                ],
                "SOCIAL_NETWORKS_FOOTER" => [
                    SocialIcons::TelegramFooter->value => "tg://resolve?domain=/",
                    SocialIcons::WhatsAppFooter->value => "whatsapp://resolve?domain=/",
                    SocialIcons::VkFooter->value => "vk://resolve?domain=/",
                    SocialIcons::DzenFooter->value => "dzen://resolve?domain=/",
                    SocialIcons::YoutubeFooter->value => "youtube://resolve?domain=/"
                ],
                "SOCIAL_NETWORKS" => [
                    SocialIcons::Telegram->value => "tg://resolve?domain=/",
                    SocialIcons::WhatsApp->value => "whatsapp://resolve?domain=/",
                    SocialIcons::Vk->value => "vk://resolve?domain=/",
                    SocialIcons::Dzen->value => "dzen://resolve?domain=/",
                    SocialIcons::Youtube->value => "youtube://resolve?domain=/"
                ],
                "LOGO" => $logo,
                "LOGO_FOOTER" => $logoFooter,
            ]);

            /** Установка настроек для английской версии сайта */
            $logo = CFile::MakeFileArray($siteSettingsDir . Manager::DEFAULT_LOGO_FILENAME);
            $logo = $logo ? CFile::SaveFile($logo, $siteSettingsUploadDir) : 0;
            $logoFooter = CFile::MakeFileArray($siteSettingsDir . Manager::DEFAULT_LOGO_FOOTER_FILENAME);
            $logoFooter = $logoFooter ? CFile::SaveFile($logoFooter, $siteSettingsUploadDir) : 0;
            Manager::updateSiteParams($this->stepData["secondarySiteId"], "en", [
                'ACTIVE' => 'Y',
                'SORT' => '2',
                'NAME' => 'Robotics competitions at PGTU',
                'DEF' => 'N',
                'DIR' => '/en/',
                'FORMAT_DATE' => 'DD.MM.YYYY',
                'FORMAT_DATETIME' => 'DD.MM.YYYY HH:MI:SS',
                'FORMAT_NAME' => '#NAME# #LAST_NAME#',
                'WEEK_START' => '1',
                'CHARSET' => 'UTF-8',
                'LANGUAGE_ID' => 'en',
                'DOMAIN_LIMITED' => 'N',
                'SERVER_NAME' => '',
                'SITE_NAME' => 'Website for robotics competitions',
            ]);
            SiteSettingsTable::add([
                "SITE_ID" => $this->stepData["secondarySiteId"],
                "LANG" => "en",
                "NAME" => "Volga region state technological university",
                "EMAIL" => "info@volgatech.net",
                "PHONE" => '+7 (987) 654-32-10',
                "ADDRESS" => "Mari El Republic, Yoshkar-Ola, V.I. Lenin Square, 3",
                "ADDRESS_ORGANISATION" => [
                    "1 building:" => "Mari El Republic, Yoshkar-Ola, V.I. Lenin Square, 3",
                    "2 building:" => "Republic of Mari El, Yoshkar-Ola, st. Sovetskaya, 158",
                    "3 building:" => "Republic of Mari El, Yoshkar-Ola, st. Panfilova, 17",
                ],
                "CONTACT_PHONES" => [
                    "Rector's reception:" => "(8362) 45-53-44",
                    "Human resources department:" => "(8362) 68-68-11",
                    "Accounting:" => "(8362) 68-78-97",
                ],
                "MAP_COORDINATES" => [
                    56.621796,
                    47.884858
                ],
                "SOCIAL_NETWORKS_FOOTER" => [
                    SocialIcons::TelegramFooter->value => "tg://resolve?domain=/",
                    SocialIcons::WhatsAppFooter->value => "whatsapp://resolve?domain=/",
                    SocialIcons::VkFooter->value => "vk://resolve?domain=/",
                    SocialIcons::DzenFooter->value => "dzen://resolve?domain=/",
                    SocialIcons::YoutubeFooter->value => "youtube://resolve?domain=/"
                ],
                "SOCIAL_NETWORKS" => [
                    SocialIcons::Telegram->value => "tg://resolve?domain=/",
                    SocialIcons::WhatsApp->value => "whatsapp://resolve?domain=/",
                    SocialIcons::Vk->value => "vk://resolve?domain=/",
                    SocialIcons::Dzen->value => "dzen://resolve?domain=/",
                    SocialIcons::Youtube->value => "youtube://resolve?domain=/"
                ],
                "LOGO" => $logo,
                "LOGO_FOOTER" => $logoFooter,
            ]);

            $connection->commitTransaction();
        } catch (Exception $exception) {
            $this->logger->error($exception);
            try {
                $connection->rollbackTransaction();
            } catch (SqlQueryException $exceptionSql) {
                $this->logger->error($exceptionSql);
                return false;
            }
        }
    }

    /**
     * Установка роутинга для контроллеров
     * @return void
     * @throws InvalidOperationException
     */
    public function installRouting()
    {
        $settings = Configuration::getInstance();
        $config = $settings->get('routing');
        if (empty($config)) {
            $config = [];
        }
        $config = array_replace_recursive($config, [
            'config' => ['robot_api.php'],
        ]);
        $settings->add('routing', $config);
        $settings->saveConfiguration();
        CopyDirFiles(__DIR__ . "/routes", Loader::getDocumentRoot() . BX_ROOT . "/routes");
    }

    /**
     * Зарегистрировать обработчики событий для модуля
     * @return void
     */
    public function installEventHandlers()
    {
        $eventManager = EventManager::getInstance();
        /** Обработчик для пользовательского поля "Временной диапазон" */
        $eventManager->registerEventHandler(
            'iblock',
            'OnIBlockPropertyBuildList',
            $this->MODULE_ID,
            UserTypeTimeRange::class,
            'getUserTypeDescription'
        );
        /** Обработчик для кастомных миграций модуля sprint.migration v5.0.2 */
        $eventManager->registerEventHandler(
            'sprint.migration',
            'OnSearchConfigFiles',
            $this->MODULE_ID,
            toClass: MigrationConfig::class,
            toMethod: 'getConfigDirectory'
        );
        /** Обработчики изменения значений справочника "Поля формы регистрации" */
        $eventManager->registerEventHandler(
            '',
            'RegistrationFieldsOnAfterAdd',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        $eventManager->registerEventHandler(
            '',
            'RegistrationFieldsOnAfterUpdate',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        $eventManager->registerEventHandler(
            '',
            'RegistrationFieldsOnAfterDelete',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        /** Обработчики изменения значений справочника "Типы полей для формы" */
        $eventManager->registerEventHandler(
            '',
            'FormTypesOnAfterAdd',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        $eventManager->registerEventHandler(
            '',
            'FormTypesOnAfterUpdate',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        $eventManager->registerEventHandler(
            '',
            'FormTypesOnAfterDelete',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        /** Обработчики изменения значений справочника "Страны" */
        $eventManager->registerEventHandler(
            '',
            'CountriesOnAfterAdd',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        $eventManager->registerEventHandler(
            '',
            'CountriesOnAfterUpdate',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        $eventManager->registerEventHandler(
            '',
            'CountriesOnAfterDelete',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        /** Обработчики изменения значений справочника "Страны - англ. версия" */
        $eventManager->registerEventHandler(
            '',
            'CountriesEnOnAfterAdd',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        $eventManager->registerEventHandler(
            '',
            'CountriesEnOnAfterUpdate',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
        $eventManager->registerEventHandler(
            '',
            'CountriesEnOnAfterDelete',
            $this->MODULE_ID,
            toClass: HighloadBlocksEventHandler::class,
            toMethod: 'onAfterChange'
        );
    }

    /**
     * Установка миграций для модуля
     * @return void
     * @throws Sprint\Migration\Exceptions\MigrationException
     */
    public function installMigrations()
    {
        if ($this->stepData["isInstallMigrations"] !== "Y") {
            return;
        }
        ob_start();
        (new Installer(MigrationConfig::getConfig()))->up();
        ob_end_clean();
    }

    /**
     * Удаление таблиц из БД
     * @return false|void
     */
    public function unInstallDb()
    {
        $connection = Application::getInstance()->getConnection();
        if (!$connection) {
            return false;
        }

        try {
            $connection->startTransaction();

            $tableName = SiteSettingsTable::getTableName();
            if ($connection->isTableExists($tableName)) {
                $connection->dropTable($tableName);
            }

            $connection->commitTransaction();
        } catch (Exception $exception) {
            $this->logger->error($exception);
            try {
                $connection->rollbackTransaction();
            } catch (SqlQueryException $exceptionSql) {
                $this->logger->error($exceptionSql);
                return false;
            }
        }
    }

    /**
     * Удаление файлов модуля
     * @return void
     */
    public function unInstallFiles(): void
    {
        $moduleUploadDir = Loader::getDocumentRoot() . '/upload' . Manager::MODULE_FILE_PATH;
        if (Directory::isDirectoryExists($moduleUploadDir)) {
            Directory::deleteDirectory($moduleUploadDir);
        }
        $siteSettingsUploadDir = Loader::getDocumentRoot() . '/upload' . Manager::SITE_SETTINGS_FILE_PATH;
        if (Directory::isDirectoryExists($siteSettingsUploadDir)) {
            Directory::deleteDirectory($siteSettingsUploadDir);
        }
        $coreAdminPath = Loader::getDocumentRoot() . BX_ROOT . "/admin/robot_core_site_settings.php";
        if (File::isFileExists($coreAdminPath)) {
            unlink($coreAdminPath);
        }
        /** Статические файлы в режиме разработки не удаляются */
        if ($_ENV['DEVELOP_MODE'] === "Y") {
            return;
        }
        /** Удаление frontend'а на vue */
        $frontendVuePath = Loader::getDocumentRoot() . $this->rootDir . Manager::FRONTEND_VUE_RELATIVE_PATH;
        if (Directory::isDirectoryExists($frontendVuePath)) {
            Directory::deleteDirectory($frontendVuePath);
        }
        /** Удаление шаблона сайта */
        $templatePath = Loader::getDocumentRoot() . $this->rootDir . Manager::TEMPLATE_RELATIVE_PATH;
        if (Directory::isDirectoryExists($templatePath)) {
            Directory::deleteDirectory($templatePath);
        }
        /** Удаление компонентов модуля */
        $componentsPath = Loader::getDocumentRoot() . $this->rootDir . Manager::COMPONENTS_RELATIVE_PATH;
        if (Directory::isDirectoryExists($componentsPath)) {
            Directory::deleteDirectory($componentsPath);
        }
    }

    /**
     * Удаление изображений из БД, связанных с настройками сайта
     * @return false|void
     */
    public function deleteImages()
    {
        try {
            $query = new Query(SiteSettingsTable::getEntity());
            $query->setOrder(["ID" => "ASC"]);
            $query->setSelect(["LOGO", "LOGO_FOOTER"]);
            $result = $query->exec();
            $rows = $result->fetchAll();

            foreach ($rows as $row) {
                !empty($row["LOGO"]) && CFile::Delete($row["LOGO"]);
                !empty($row["LOGO_FOOTER"]) && CFile::Delete($row["LOGO_FOOTER"]);
            }
        } catch (Exception $exception) {
            $this->logger->error($exception);
            return false;
        }
    }

    /**
     * Удалить роутинг для контроллеров
     * @return void
     * @throws InvalidOperationException
     */
    public function unInstallRouting()
    {
        $settings = Configuration::getInstance();
        $config = $settings->get('routing');
        if (!is_array($config) || !isset($config['config']) || !is_array($config['config'])) {
            return;
        }
        $config['config'] = array_diff($config['config'], ['robot_api.php']);
        $settings->add('routing', $config);
        $settings->saveConfiguration();
        DeleteDirFiles(__DIR__ . "/routes", Loader::getDocumentRoot() . BX_ROOT . "/routes");
    }

    /**
     * Убрать обработчики событий, зарегистрированные для модуля
     * @return void
     */
    public function unInstallEventHandlers()
    {
        $eventManager = EventManager::getInstance();
        /** Обработчик для пользовательского поля "Временной диапазон" */
        $eventManager->unRegisterEventHandler(
            'iblock',
            'OnIBlockPropertyBuildList',
            $this->MODULE_ID,
            UserTypeTimeRange::class,
            'getUserTypeDescription'
        );
        /** Обработчик для кастомных миграций модуля sprint.migration v5.0.2 */
        $eventManager->unRegisterEventHandler(
            'sprint.migration',
            'OnSearchConfigFiles',
            $this->MODULE_ID,
            MigrationConfig::class,
            'getConfigDirectory'
        );
        /** Обработчики изменения значений справочника "Поля формы регистрации" */
        $eventManager->unRegisterEventHandler(
            '',
            'RegistrationFieldsOnAfterAdd',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        $eventManager->unRegisterEventHandler(
            '',
            'RegistrationFieldsOnAfterUpdate',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        $eventManager->unRegisterEventHandler(
            '',
            'RegistrationFieldsOnAfterDelete',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        /** Обработчики изменения значений справочника "Типы полей для формы" */
        $eventManager->unRegisterEventHandler(
            '',
            'FormTypesOnAfterAdd',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        $eventManager->unRegisterEventHandler(
            '',
            'FormTypesOnAfterUpdate',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        $eventManager->unRegisterEventHandler(
            '',
            'FormTypesOnAfterDelete',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        /** Обработчики изменения значений справочника "Страны" */
        $eventManager->unRegisterEventHandler(
            '',
            'CountriesOnAfterAdd',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        $eventManager->unRegisterEventHandler(
            '',
            'CountriesOnAfterUpdate',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        $eventManager->unRegisterEventHandler(
            '',
            'CountriesOnAfterDelete',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        /** Обработчики изменения значений справочника "Страны - англ. версия" */
        $eventManager->unRegisterEventHandler(
            '',
            'CountriesEnOnAfterAdd',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        $eventManager->unRegisterEventHandler(
            '',
            'CountriesEnOnAfterUpdate',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
        $eventManager->unRegisterEventHandler(
            '',
            'CountriesEnOnAfterDelete',
            $this->MODULE_ID,
            HighloadBlocksEventHandler::class,
            'onAfterChange'
        );
    }
}