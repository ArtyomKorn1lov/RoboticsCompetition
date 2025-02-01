<?php

namespace Sprint\Migration;

class ActionsIBElements20250201194008 extends Version
{
    protected $author = "admin";

    protected $description = "Элементы ИБ \"Мероприятия\"";

    protected $moduleVersion = "4.18.0";

    /**
     * @return bool|void
     * @throws Exceptions\RestartException
     * @throws Exceptions\MigrationException
     */
    public function up()
    {
        $this->getExchangeManager()
            ->IblockElementsImport()
            ->setExchangeResource('iblock_elements.xml')
            ->setLimit(20)
            ->execute(function ($item) {
                $this->getHelperManager()
                    ->Iblock()
                    ->saveElementByXmlId(
                        $item['iblock_id'],
                        $item['fields'],
                        $item['properties']
                    );
            });
    }

    /**
     * @return bool|void
     * @throws Exceptions\RestartException
     * @throws Exceptions\MigrationException
     */
    public function down()
    {
        $this->getExchangeManager()
            ->IblockElementsImport()
            ->setExchangeResource('iblock_elements.xml')
            ->setLimit(10)
            ->execute(function ($item) {
                $this->getHelperManager()
                    ->Iblock()
                    ->deleteElementByXmlId(
                        $item['iblock_id'],
                        $item['fields']['XML_ID']
                    );
            });
    }
}
