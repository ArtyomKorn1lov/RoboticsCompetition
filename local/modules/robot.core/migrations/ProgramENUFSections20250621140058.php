<?php

namespace Sprint\Migration;


class ProgramENUFSections20250621140058 extends Version
{
    protected $author = "admin";

    protected $description = "Пользовательские поля разделов ИБ программа - англ. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->UserTypeEntity()->saveUserTypeEntity(array(
            'ENTITY_ID' => 'IBLOCK_robot_content:program_en_SECTION',
            'FIELD_NAME' => 'UF_EVENTS',
            'USER_TYPE_ID' => 'iblock_element',
            'XML_ID' => '8e94c260-b0ae-4b2e-82a7-59c555e00a66',
            'SORT' => '100',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'Y',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'DISPLAY' => 'DIALOG',
                    'LIST_HEIGHT' => 1,
                    'IBLOCK_ID' => 'robot_content:events_en',
                    'DEFAULT_VALUE' => '',
                    'ACTIVE_FILTER' => 'N',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Event',
                    'ru' => 'Событие',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Event',
                    'ru' => 'Событие',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Event',
                    'ru' => 'Событие',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Event',
                    'ru' => 'Событие',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Event',
                    'ru' => 'Событие',
                ),
        ));
    }

}
