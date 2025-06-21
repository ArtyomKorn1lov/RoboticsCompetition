<?php

namespace Sprint\Migration;

class VideoLessonsENIBElements20250621140912 extends Version
{
    protected $author = "admin";

    protected $description = "Элементы ИБ видеоуроки - англ. версия";

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
}
