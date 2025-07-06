<?php

namespace Sprint\Migration;


class CountriesENHL20250621141810 extends Version
{
    protected $author = "admin";

    protected $description = "Справочник страны - англ. версия";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $hlblockId = $helper->Hlblock()->saveHlblock(array(
            'NAME' => 'CountriesEn',
            'TABLE_NAME' => 'robot_countries_en',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Страны - англ. версия',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Countries - en. version',
                        ),
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_VALUE',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => '722a807d-8d5e-485e-b2d0-f1af5e27bd93',
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
            'XML_ID' => '7e019c32-a97c-4268-be6c-8b974b2f2ce7',
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
            'XML_ID' => '5e99eb33-90f9-4324-a965-1765895eb812',
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
            'XML_ID' => '4adb0ad9-5584-468c-9ac3-7d13fcdec3ed',
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
