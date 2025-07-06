<?php

namespace Sprint\Migration;


class CountriesHL20250621141721 extends Version
{
    protected $author = "admin";

    protected $description = "Справочник страны - осн. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $hlblockId = $helper->Hlblock()->saveHlblock(array(
            'NAME' => 'Countries',
            'TABLE_NAME' => 'robot_countries',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Страны',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Countries',
                        ),
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_VALUE',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => '396f0fd8-5429-4a7f-9742-fdc6816cd38c',
            'SORT' => '100',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'Y',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'SIZE' => 20,
                    'ROWS' => 1,
                    'REGEXP' => '',
                    'MIN_LENGTH' => 0,
                    'MAX_LENGTH' => 0,
                    'DEFAULT_VALUE' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Value',
                    'ru' => 'Значение',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Value',
                    'ru' => 'Значение',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Value',
                    'ru' => 'Значение',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Value',
                    'ru' => 'Значение',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Value',
                    'ru' => 'Значение',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_CODE',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => 'dc978ea4-af4d-44c4-9aba-06e6073d21d7',
            'SORT' => '200',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'Y',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'SIZE' => 20,
                    'ROWS' => 1,
                    'REGEXP' => '',
                    'MIN_LENGTH' => 0,
                    'MAX_LENGTH' => 0,
                    'DEFAULT_VALUE' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Code',
                    'ru' => 'Код',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Code',
                    'ru' => 'Код',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Code',
                    'ru' => 'Код',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Code',
                    'ru' => 'Код',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Code',
                    'ru' => 'Код',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_SORT',
            'USER_TYPE_ID' => 'integer',
            'XML_ID' => '8d6df3a2-80b0-4501-a5b0-3a70eee12246',
            'SORT' => '300',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'Y',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'SIZE' => 20,
                    'MIN_VALUE' => 0,
                    'MAX_VALUE' => 0,
                    'DEFAULT_VALUE' => NULL,
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Sort',
                    'ru' => 'Сортировка',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Sort',
                    'ru' => 'Сортировка',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Sort',
                    'ru' => 'Сортировка',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Sort',
                    'ru' => 'Сортировка',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Sort',
                    'ru' => 'Сортировка',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_XML_ID',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => '9a8b8e8b-56d7-4a81-9d60-bbe6649acda2',
            'SORT' => '400',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'Y',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'SIZE' => 20,
                    'ROWS' => 1,
                    'REGEXP' => '',
                    'MIN_LENGTH' => 0,
                    'MAX_LENGTH' => 0,
                    'DEFAULT_VALUE' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'External key',
                    'ru' => 'Внешний код',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'External key',
                    'ru' => 'Внешний код',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'External key',
                    'ru' => 'Внешний код',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'External key',
                    'ru' => 'Внешний код',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'External key',
                    'ru' => 'Внешний код',
                ),
        ));
    }
}
