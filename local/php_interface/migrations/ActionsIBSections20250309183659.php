<?php

namespace Sprint\Migration;


class ActionsIBSections20250309183659 extends Version
{
    protected $author = "admin";

    protected $description = "Разделы ИБ \"Мероприятия\"";

    protected $moduleVersion = "4.18.0";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'actions',
            'robot_content'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array(
                0 =>
                    array(
                        'NAME' => 'Региональный фестиваль по робототехнике в ПГТУ',
                        'CODE' => 'sorevnovaniya-2025',
                        'SORT' => '100',
                        'ACTIVE' => 'Y',
                        'XML_ID' => 'b26a54b1-b8df-43ce-be93-b57944d653c5',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                        'UF_EVENTS' => '1',
                    ),
            ));
    }
}
