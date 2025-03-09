<?php

namespace Sprint\Migration;


class ProgramIBSections20250309184810 extends Version
{
    protected $author = "admin";

    protected $description = "Разделы ИБ \"Программа\"";

    protected $moduleVersion = "4.18.0";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'program',
            'robot_content'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array(
                0 =>
                    array(
                        'NAME' => 'Программа проведения соревнований 2025 года',
                        'CODE' => 'programma-provedeniya-sorevnovaniy-2025-goda',
                        'SORT' => '100',
                        'ACTIVE' => 'Y',
                        'XML_ID' => 'f77b608a-9caf-4423-a0f7-237fad8cbaf9',
                        'DESCRIPTION' => '',
                        'DESCRIPTION_TYPE' => 'text',
                        'UF_EVENTS' => '1',
                    ),
            ));
    }
}
