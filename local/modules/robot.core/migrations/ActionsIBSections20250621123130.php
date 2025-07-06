<?php

namespace Sprint\Migration;


class ActionsIBSections20250621123130 extends Version
{
    protected $author = "admin";

    protected $description = "Разделы ИБ мероприятия - осн. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $eventIblockId = $helper->Iblock()->getIblockIdIfExists(
            'events',
            'robot_content'
        );
        $eventId = $helper->Iblock()->getElementId(
            iblockId: $eventIblockId,
            code: 'regionalnyy-festival-po-robototekhnike-v-pgtu'
        );
        if (!$eventId) {
            $this->outWarning('Не найден указанный в миграции элемент события');
            $eventId = 0;
        }

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
                        'CODE' => 'sorevnovaniya-2026',
                        'SORT' => '100',
                        'ACTIVE' => 'Y',
                        'XML_ID' => 'b26a54b1-b8df-43ce-be93-b57944d653c5',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                        'UF_EVENTS' => $eventId,
                    ),
            ));
    }
}
