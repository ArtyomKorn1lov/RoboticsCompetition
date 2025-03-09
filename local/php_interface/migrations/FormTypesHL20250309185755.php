<?php

namespace Sprint\Migration;


class FormTypesHL20250309185755 extends Version
{
    protected $author = "admin";

    protected $description = "Справочник \"Типы полей для формы\"";

    protected $moduleVersion = "4.18.0";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $hlblockId = $helper->Hlblock()->saveHlblock(array(
            'NAME' => 'FormTypes',
            'TABLE_NAME' => 'robot_form_types',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Типы полей для формы',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Form Field Types',
                        ),
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_NAME',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => '817e3bfa-ef9e-4987-8439-e6cc356f1f38',
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
                    'en' => 'Name',
                    'ru' => 'Название',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Name',
                    'ru' => 'Название',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Name',
                    'ru' => 'Название',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Name',
                    'ru' => 'Название',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Name',
                    'ru' => 'Название',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_CODE',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => '265e557f-b514-4ca2-8566-dacc10f566ac',
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
                    'en' => 'Field code',
                    'ru' => 'Код поля',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Field code',
                    'ru' => 'Код поля',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Field code',
                    'ru' => 'Код поля',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Field code',
                    'ru' => 'Код поля',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Field code',
                    'ru' => 'Код поля',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_SORT',
            'USER_TYPE_ID' => 'double',
            'XML_ID' => 'a02b4e8b-ebe6-49c6-9a89-32ecea62401e',
            'SORT' => '300',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'Y',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'PRECISION' => 4,
                    'SIZE' => 20,
                    'MIN_VALUE' => 0.0,
                    'MAX_VALUE' => 0.0,
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
            'XML_ID' => 'f2e530cf-e650-47f6-b42b-79f376e7b820',
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
