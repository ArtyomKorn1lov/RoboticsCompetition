<?php

namespace Sprint\Migration;


class ArchiveIBSections20250621130436 extends Version
{
    protected $author = "admin";

    protected $description = "Разделы ИБ архив - осн. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'archive',
            'robot_content'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array(
                0 =>
                    array(
                        'NAME' => '2024 год',
                        'CODE' => '2024-god',
                        'SORT' => '100',
                        'ACTIVE' => 'Y',
                        'XML_ID' => '739da6b5-78b4-4bcb-978e-c0c9510b9f86',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                    ),
                1 =>
                    array(
                        'NAME' => '2023 год',
                        'CODE' => '2023-god',
                        'SORT' => '200',
                        'ACTIVE' => 'Y',
                        'XML_ID' => '34bb167e-d8e3-4d08-826b-667ca1b8efc3',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                    ),
            ));
    }
}
