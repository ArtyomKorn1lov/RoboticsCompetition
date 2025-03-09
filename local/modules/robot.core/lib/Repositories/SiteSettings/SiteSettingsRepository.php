<?php

namespace Robot\Core\Repositories\SiteSettings;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Robot\Core\Entity\SiteSettings\SiteSettingsTable;

class SiteSettingsRepository implements ISiteSettingsRepository
{
    /**
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getSiteSettingsHeader(): array
    {
        $query = new Query(SiteSettingsTable::getEntity());
        $query->setOrder(["ID" => "ASC"]);
        $query->setFilter(["=SITE_ID" => SITE_ID]);
        $query->setLimit(1);
        $query->setSelect(SiteSettingsTable::getHeaderSelectedFields());
        $result = $query->exec();
        $rows = $result->fetchAll();
        if (!$rows) {
            return [];
        }
        return $rows[0];
    }

    /**
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getSiteSettingsFooter(): array
    {
        $query = new Query(SiteSettingsTable::getEntity());
        $query->setOrder(["ID" => "ASC"]);
        $query->setFilter(["=SITE_ID" => SITE_ID]);
        $query->setLimit(1);
        $query->setSelect(SiteSettingsTable::getFooterSelectedFields());
        $result = $query->exec();
        $rows = $result->fetchAll();
        if (!$rows) {
            return [];
        }
        return $rows[0];
    }

    /**
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getSiteSettingsContacts(): array
    {
        $query = new Query(SiteSettingsTable::getEntity());
        $query->setOrder(["ID" => "ASC"]);
        $query->setFilter(["=SITE_ID" => SITE_ID]);
        $query->setLimit(1);
        $query->setSelect(SiteSettingsTable::getContactsSelectedFields());
        $result = $query->exec();
        $rows = $result->fetchAll();
        if (!$rows) {
            return [];
        }
        return $rows[0];
    }
}