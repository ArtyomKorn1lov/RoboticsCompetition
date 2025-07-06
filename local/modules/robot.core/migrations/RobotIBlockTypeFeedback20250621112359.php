<?php

namespace Sprint\Migration;


class RobotIBlockTypeFeedback20250621112359 extends Version
{
    protected $author = "admin";

    protected $description = "Тип для ИБ - обратная связь";

    protected $moduleVersion = "5.0.2";

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
                            'NAME' => 'Соревнования - обратная связь',
                            'SECTION_NAME' => 'Соревнования - обратная связь',
                            'ELEMENT_NAME' => 'Соревнования - обратная связь',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Competitions - feedback',
                            'SECTION_NAME' => 'Competitions - feedback',
                            'ELEMENT_NAME' => 'Competitions - feedback',
                        ),
                ),
        ));
    }
}
