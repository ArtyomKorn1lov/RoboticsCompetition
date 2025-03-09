<?php

namespace Sprint\Migration;


class RobotFeedbackIBlockType20250309183050 extends Version
{
    protected $author = "admin";

    protected $description = "Тип инфоблока \"Робототехника обратная связь\"";

    protected $moduleVersion = "4.18.0";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Iblock()->saveIblockType(array(
            'ID' => 'robot_feedback',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => '200',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Робототехника обратная связь',
                            'SECTION_NAME' => 'Робототехника обратная связь',
                            'ELEMENT_NAME' => 'Робототехника обратная связь',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Robotics feedback',
                            'SECTION_NAME' => 'Robotics feedback',
                            'ELEMENT_NAME' => 'Robotics feedback',
                        ),
                ),
        ));
    }
}
