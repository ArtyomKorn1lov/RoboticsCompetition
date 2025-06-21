<?php

namespace Sprint\Migration;


class ActionsUFSections20250621123011 extends Version
{
    protected $author = "admin";

    protected $description = "Пользовательские поля разделов ИБ мероприятия - осн. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->UserTypeEntity()->saveUserTypeEntity(array(
            'ENTITY_ID' => 'IBLOCK_robot_content:actions_SECTION',
            'FIELD_NAME' => 'UF_EVENTS',
            'USER_TYPE_ID' => 'iblock_element',
            'XML_ID' => '6ede6eee-3099-4534-8368-fa0c115ceda9',
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
                    'IBLOCK_ID' => 'robot_content:events',
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
