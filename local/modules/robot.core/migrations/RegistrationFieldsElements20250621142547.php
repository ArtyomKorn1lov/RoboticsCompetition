<?php

namespace Sprint\Migration;


class RegistrationFieldsElements20250621142547 extends Version
{
    protected $author = "admin";

    protected $description = "Элементы справочника поля формы регистрации";

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

}
