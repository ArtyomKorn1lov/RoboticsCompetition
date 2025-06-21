<?php

namespace Sprint\Migration;


class FormTypesHLElements20250621142317 extends Version
{
    protected $author = "admin";

    protected $description = "Элементы справочника типы полей для формы";

    protected $moduleVersion = "5.0.2";

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
