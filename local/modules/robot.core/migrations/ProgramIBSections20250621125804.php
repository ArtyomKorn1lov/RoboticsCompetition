<?php

namespace Sprint\Migration;


class ProgramIBSections20250621125804 extends Version
{
    protected $author = "admin";

    protected $description = "Разделы ИБ программа - осн. версия";

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
            'program',
            'robot_content'
        );
        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array(
                0 =>
                    array(
                        'NAME' => 'Программа проведения соревнований 2026 года',
                        'CODE' => 'programma-provedeniya-sorevnovaniy-2026-goda',
                        'SORT' => '100',
                        'ACTIVE' => 'Y',
                        'XML_ID' => 'f77b608a-9caf-4423-a0f7-237fad8cbaf9',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                        'UF_EVENTS' => $eventId,
                    ),
            ));
    }
}
