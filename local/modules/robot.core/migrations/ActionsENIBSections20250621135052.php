<?php

namespace Sprint\Migration;


class ActionsENIBSections20250621135052 extends Version
{
    protected $author = "admin";

    protected $description = "Разделы ИБ мероприятия - англ. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $eventIblockId = $helper->Iblock()->getIblockIdIfExists(
            'events_en',
            'robot_content'
        );
        $eventId = $helper->Iblock()->getElementId(
            iblockId: $eventIblockId,
            code: 'regional-festival-on-robotics-in-pgtu'
        );
        if (!$eventId) {
            $this->outWarning('Не найден указанный в миграции элемент события');
            $eventId = 0;
        }

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'actions_en',
            'robot_content'
        );
        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array(
                0 =>
                    array(
                        'NAME' => 'Regional festival on robotics in PGTU',
                        'CODE' => 'regional-festival-on-robotics-in-pgtu',
                        'SORT' => '100',
                        'ACTIVE' => 'Y',
                        'XML_ID' => '83d88c3c-5e58-4345-90f0-11324d1a854b',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                        'UF_EVENTS' => $eventId,
                    ),
            ));
    }
}
