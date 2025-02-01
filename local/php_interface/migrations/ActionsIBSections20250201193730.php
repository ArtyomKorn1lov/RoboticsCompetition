<?php

namespace Sprint\Migration;


class ActionsIBSections20250201193730 extends Version
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
            'content'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array(
                0 =>
                    array(
                        'NAME' => 'Соревнования 2025',
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
