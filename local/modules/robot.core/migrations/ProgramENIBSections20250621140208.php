<?php

namespace Sprint\Migration;


class ProgramENIBSections20250621140208 extends Version
{
    protected $author = "admin";

    protected $description = "Разделы ИБ программа - англ. версия";

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
            'program_en',
            'robot_content'
        );
        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array(
                0 =>
                    array(
                        'NAME' => 'Competition program for 2026',
                        'CODE' => 'competition-program-for-2026',
                        'SORT' => '100',
                        'ACTIVE' => 'Y',
                        'XML_ID' => '5a980d64-7808-40d2-8f26-87e9ae2800df',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                        'UF_EVENTS' => $eventId,
                    ),
            ));
    }
}
