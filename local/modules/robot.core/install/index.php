<?php
//подключаем основные классы для работы с модулем
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\IO\Directory;

use Robot\Core\Tools\Modules\Manager;
use Robot\Core\Entity\SiteSettingsTable;

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
        $this->MODULE_NAME = Loc::getMessage('MAIN_MODULE_NAME');
        //описание модуля
        $this->MODULE_DESCRIPTION = Loc::getMessage('MAIN_MODULE_DESCRIPTION');
        //используем ли индивидуальную схему распределения прав доступа, мы ставим N, так как не используем ее
        $this->MODULE_GROUP_RIGHTS = 'N';
        //название компании партнера предоставляющей модуль
        $this->PARTNER_NAME = Loc::getMessage('MAIN_MODULE_PARTNER_NAME');
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
        ModuleManager::unRegisterModule($this->MODULE_ID);
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
                "SITE_ID" => SITE_ID,
                "EMAIL" => "competation@mail.com",
                "PHONE" => '8 (999) 999-99-99, +7 (800) 999-91-92',
                "ADDRESS" => "Республика Марий Эл, г. Йошкар-Ола, площадь имени В.И. Ленина, 3",
                "SOCIAL_NETWORKS" => [
                    "telegram_footer" => "tg://resolve?domain=/",
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
}