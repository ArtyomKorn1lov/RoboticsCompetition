<?php

namespace Sprint\Migration;


class RobotIBlockTypeContent20250621112040 extends Version
{
    protected $author = "admin";

    protected $description = "Тип для ИБ - контент";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Iblock()->saveIblockType(array(
            'ID' => 'robot_content',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => '100',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Соревнования - контент',
                            'SECTION_NAME' => 'Соревнования - контент',
                            'ELEMENT_NAME' => 'Соревнования - контент',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Competitions - content',
                            'SECTION_NAME' => 'Competitions - content',
                            'ELEMENT_NAME' => 'Competitions - content',
                        ),
                ),
        ));
    }
}
