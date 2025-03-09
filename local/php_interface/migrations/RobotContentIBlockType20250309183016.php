<?php

namespace Sprint\Migration;


class RobotContentIBlockType20250309183016 extends Version
{
    protected $author = "admin";

    protected $description = "Тип инфоблока \"Робототехника контент\"";

    protected $moduleVersion = "4.18.0";

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
                            'NAME' => 'Робототехника контент',
                            'SECTION_NAME' => 'Робототехника контент',
                            'ELEMENT_NAME' => 'Робототехника контент',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Robotics content',
                            'SECTION_NAME' => 'Robotics content',
                            'ELEMENT_NAME' => 'Robotics content',
                        ),
                ),
        ));
    }
}
