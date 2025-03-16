<?php
//подключаем основные классы для работы с модулем
use Bitrix\Main\Application;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\IO\Directory;

use Robot\Core\Tools\Modules\Manager;
use Robot\Core\Entity\SiteSettings\SiteSettingsTable;

Loc::loadMessages(__FILE__);

//в названии класса пишем название директории нашего модуля, только вместо точки ставим нижнее подчеркивание
class robot_core extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();
        //подключаем версию модуля (файл будет следующим в списке)
        include __DIR__ . '/version.php';
        //присваиваем свойствам класса переменные из нашего файла
        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        //пишем название нашего модуля как и директории
        $this->MODULE_ID = 'robot.core';
        // название модуля
        $this->MODULE_NAME = Loc::getMessage('ROBOT_MODULE_NAME');
        //описание модуля
        $this->MODULE_DESCRIPTION = Loc::getMessage('ROBOT_MODULE_DESCRIPTION');
        //используем ли индивидуальную схему распределения прав доступа, мы ставим N, так как не используем ее
        $this->MODULE_GROUP_RIGHTS = 'N';
        //название компании партнера предоставляющей модуль
        $this->PARTNER_NAME = Loc::getMessage('ROBOT_MODULE_PARTNER_NAME');
    }

    //здесь мы описываем все, что делаем до инсталляции модуля, мы добавляем наш модуль в регистр
    public function doInstall(): void
    {
        global $APPLICATION;
        try {
            ModuleManager::registerModule($this->MODULE_ID);
            Loader::includeModule($this->MODULE_ID);

            $this->installFiles();
            $this->installDb();
        }
        catch (Exception $exception) {
            ModuleManager::unRegisterModule($this->MODULE_ID);
            AddMessage2Log($exception->getMessage(), $this->MODULE_ID);
            $APPLICATION->ThrowException($exception->getMessage());
        }
    }

    //вызываем метод удаления таблицы и удаляем модуль из регистра
    public function doUninstall(): void
    {
        global $APPLICATION;
        try {
            Loader::includeModule($this->MODULE_ID);
            $this->deleteImages();
            $this->unInstallDb();
            $this->unInstallFiles();
            ModuleManager::unRegisterModule($this->MODULE_ID);
        } catch (Exception $exception) {
            ModuleManager::unRegisterModule($this->MODULE_ID);
            AddMessage2Log($exception->getMessage(), $this->MODULE_ID);
            $APPLICATION->ThrowException($exception->getMessage());
        }
    }

    /**
     * Установка файлов
     * @return void
     */
    public function installFiles(): void
    {
        $moduleUploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload' . Manager::MODULE_FILE_PATH;
        if (!Directory::isDirectoryExists($moduleUploadDir)) {
            Directory::createDirectory($moduleUploadDir);
        }
        $siteSettingsUploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload' . Manager::SITE_SETTINGS_FILE_PATH;
        if (!Directory::isDirectoryExists($siteSettingsUploadDir)) {
            Directory::createDirectory($siteSettingsUploadDir);
        }
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

            $siteSettingsDir = __DIR__ . "\\public\\assets\\";
            $siteSettingsUploadDir = Manager::SITE_SETTINGS_FILE_PATH;
            $logo = CFile::MakeFileArray($siteSettingsDir . Manager::DEFAULT_LOGO_FILENAME);
            $logo = $logo ? CFile::SaveFile($logo, $siteSettingsUploadDir) : 0;
            $logoFooter = CFile::MakeFileArray($siteSettingsDir . Manager::DEFAULT_LOGO_FOOTER_FILENAME);
            $logoFooter = $logoFooter ? CFile::SaveFile($logoFooter, $siteSettingsUploadDir) : 0;

            SiteSettingsTable::add([
                "SITE_ID" => "s1",
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
                    "telegram_footer" => "tg://resolve?domain=/",
                ],
                "SOCIAL_NETWORKS" => [
                    "telegram" => "tg://resolve?domain=/",
                ],
                "LOGO" => $logo,
                "LOGO_FOOTER" => $logoFooter,
            ]);

            $connection->commitTransaction();
        } catch (Exception $exception) {
            AddMessage2Log($exception->getMessage(), $this->MODULE_ID);
            try {
                $connection->rollbackTransaction();
            } catch (SqlQueryException $exceptionSql) {
                AddMessage2Log($exceptionSql->getMessage(), $this->MODULE_ID);
                return false;
            }
        }
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
            AddMessage2Log($exception->getMessage(), $this->MODULE_ID);
            try {
                $connection->rollbackTransaction();
            } catch (SqlQueryException $exceptionSql) {
                AddMessage2Log($exceptionSql->getMessage(), $this->MODULE_ID);
                return false;
            }
        }
    }

    /**
     * Удаление таблиц из БД
     * @return void
     */
    public function unInstallFiles()
    {
        $moduleUploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload' . Manager::MODULE_FILE_PATH;
        if (Directory::isDirectoryExists($moduleUploadDir)) {
            Directory::deleteDirectory($moduleUploadDir);
        }
        $siteSettingsUploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload' . Manager::SITE_SETTINGS_FILE_PATH;
        if (Directory::isDirectoryExists($siteSettingsUploadDir)) {
            Directory::deleteDirectory($siteSettingsUploadDir);
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
            $query->setFilter(["=SITE_ID" => "s1"]);
            $query->setLimit(1);
            $query->setSelect(["LOGO", "LOGO_FOOTER"]);
            $result = $query->exec();
            $rows = $result->fetchAll();

            foreach ($rows as $row) {
                !empty($row["LOGO"]) && CFile::Delete($row["LOGO"]);
                !empty($row["LOGO_FOOTER"]) && CFile::Delete($row["LOGO_FOOTER"]);
            }
        } catch (Exception $exception) {
            AddMessage2Log($exception->getMessage(), $this->MODULE_ID);
            return false;
        }
    }
}