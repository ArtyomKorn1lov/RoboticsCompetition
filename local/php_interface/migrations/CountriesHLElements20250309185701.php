<?php

namespace Sprint\Migration;


class CountriesHLElements20250309185701 extends Version
{
    protected $author = "admin";

    protected $description = "Элементы справочника \"Страны\"";

    protected $moduleVersion = "4.18.0";

    /**
     * @return bool|void
     * @throws Exceptions\RestartException
     * @throws Exceptions\HelperException
     * @throws Exceptions\MigrationException
     */
    public function up()
    {
        $this->getExchangeManager()
            ->HlblockElementsImport()
            ->setExchangeResource('hlblock_elements.xml')
            ->setLimit(20)
            ->execute(function ($item) {
                $this->getHelperManager()
                    ->Hlblock()
                    ->saveElementByXmlId(
                        $item['hlblock_id'],
                        $item['fields']
                    );
            });
    }

    /**
     * @return bool|void
     * @throws Exceptions\RestartException
     * @throws Exceptions\HelperException
     * @throws Exceptions\MigrationException
     */
    public function down()
    {
        $this->getExchangeManager()
            ->HlblockElementsImport()
            ->setExchangeResource('hlblock_elements.xml')
            ->setLimit(20)
            ->execute(function ($item) {
                $this->getHelperManager()
                    ->Hlblock()
                    ->deleteElementByXmlId(
                        $item['hlblock_id'],
                        $item['fields']['UF_XML_ID']
                    );
            });
    }


}
