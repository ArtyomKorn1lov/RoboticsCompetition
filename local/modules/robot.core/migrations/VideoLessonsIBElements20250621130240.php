<?php

namespace Sprint\Migration;

class VideoLessonsIBElements20250621130240 extends Version
{
    protected $author = "admin";

    protected $description = "Элементы ИБ видеоуроки - осн. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\RestartException
     * @throws Exceptions\MigrationException
     */
    public function up()
    {
        $this->getExchangeManager()
            ->IblockElementsImport()
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
