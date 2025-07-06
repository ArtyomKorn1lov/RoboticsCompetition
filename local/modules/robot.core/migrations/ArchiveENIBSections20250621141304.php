<?php

namespace Sprint\Migration;


class ArchiveENIBSections20250621141304 extends Version
{
    protected $author = "admin";

    protected $description = "Разделы ИБ архив - англ. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'archive_en',
            'robot_content'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array(
                0 =>
                    array(
                        'NAME' => '2024 year',
                        'CODE' => '2024-year',
                        'SORT' => '100',
                        'ACTIVE' => 'Y',
                        'XML_ID' => 'de1744fc-a298-42a2-9a68-bd59b3c0d43f',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                    ),
                1 =>
                    array(
                        'NAME' => '2023 year',
                        'CODE' => '2023-year',
                        'SORT' => '200',
                        'ACTIVE' => 'Y',
                        'XML_ID' => 'aae1c6ab-bc87-4272-8804-23180ed115aa',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                    ),
            ));
    }
}
