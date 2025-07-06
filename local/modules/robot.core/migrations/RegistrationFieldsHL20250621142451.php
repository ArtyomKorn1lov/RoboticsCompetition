<?php

namespace Sprint\Migration;


class RegistrationFieldsHL20250621142451 extends Version
{
    protected $author = "admin";

    protected $description = "Справочник поля формы регистрации";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $hlblockId = $helper->Hlblock()->saveHlblock(array(
            'NAME' => 'RegistrationFields',
            'TABLE_NAME' => 'robot_registration_fields',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Поля формы регистрации',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Registration form fields',
                        ),
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_NAME',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => 'ea161acd-31a6-43e8-ab8a-c04c935e9ce4',
            'SORT' => '100',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'SIZE' => 40,
                    'ROWS' => 1,
                    'REGEXP' => '',
                    'MIN_LENGTH' => 0,
                    'MAX_LENGTH' => 0,
                    'DEFAULT_VALUE' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Title',
                    'ru' => 'Заголовок',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Title',
                    'ru' => 'Заголовок',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Title',
                    'ru' => 'Заголовок',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Title',
                    'ru' => 'Заголовок',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Title',
                    'ru' => 'Заголовок',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_CODE',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => 'c788d475-2a39-44b9-a057-3f4530ca1681',
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
            'USER_TYPE_ID' => 'double',
            'XML_ID' => '35bbf6d9-07d0-489a-accc-3e0f93f5d57c',
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
            'XML_ID' => '5ecfe014-dcee-417c-98ba-f93174912f1e',
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
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_PLACEHOLDER',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => '1e94aac2-9f09-4336-bfff-530241e58e2a',
            'SORT' => '500',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'SIZE' => 40,
                    'ROWS' => 1,
                    'REGEXP' => '',
                    'MIN_LENGTH' => 0,
                    'MAX_LENGTH' => 0,
                    'DEFAULT_VALUE' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Placeholder',
                    'ru' => 'Заполнитель',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Placeholder',
                    'ru' => 'Заполнитель',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Placeholder',
                    'ru' => 'Заполнитель',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Placeholder',
                    'ru' => 'Заполнитель',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Placeholder',
                    'ru' => 'Заполнитель',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_REQUIRED',
            'USER_TYPE_ID' => 'boolean',
            'XML_ID' => '21df232b-70b9-4ba5-8dc6-c35da4a0236b',
            'SORT' => '600',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'DEFAULT_VALUE' => 0,
                    'DISPLAY' => 'CHECKBOX',
                    'LABEL' =>
                        array(
                            0 => '',
                            1 => '',
                        ),
                    'LABEL_CHECKBOX' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Field required?',
                    'ru' => 'Обязательное поле?',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Field required?',
                    'ru' => 'Обязательное поле?',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Field required?',
                    'ru' => 'Обязательное поле?',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Field required?',
                    'ru' => 'Обязательное поле?',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Field required?',
                    'ru' => 'Обязательное поле?',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_FIELD_TYPE',
            'USER_TYPE_ID' => 'hlblock',
            'XML_ID' => '0e888e8f-f0fa-4f8c-853a-dfff6b690e9a',
            'SORT' => '700',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'Y',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'DISPLAY' => 'LIST',
                    'LIST_HEIGHT' => 1,
                    'HLBLOCK_ID' => 'FormTypes',
                    'HLFIELD_ID' => 'UF_NAME',
                    'DEFAULT_VALUE' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Field type',
                    'ru' => 'Тип поля',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Field type',
                    'ru' => 'Тип поля',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Field type',
                    'ru' => 'Тип поля',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Field type',
                    'ru' => 'Тип поля',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Field type',
                    'ru' => 'Тип поля',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_VALUES',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => 'd0530cd7-d61d-4cb4-9284-bb8c56a46a7d',
            'SORT' => '800',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
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
                    'en' => 'Field values ​​for select, autocomplete types (specify the entity name)',
                    'ru' => 'Значения поля для типов select, autocomplete (укажите название сущности)',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Field values ​​for select, autocomplete types (specify the entity name)',
                    'ru' => 'Значения поля для типов select, autocomplete (укажите название сущности)',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Field values ​​for select, autocomplete types (specify the entity name)',
                    'ru' => 'Значения поля для типов select, autocomplete (укажите название сущности)',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Field values ​​for select, autocomplete types (specify the entity name)',
                    'ru' => 'Значения поля для типов select, autocomplete (укажите название сущности)',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Field values ​​for select, autocomplete types (specify the entity name)',
                    'ru' => 'Значения поля для типов select, autocomplete (укажите название сущности)',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_LANG',
            'USER_TYPE_ID' => 'string',
            'XML_ID' => '34f6eaff-8338-482e-82ff-17f7b5b20019',
            'SORT' => '1000',
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
                    'en' => 'Language version of the site (en or ru)',
                    'ru' => 'Языковая версия сайта (en или ru)',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Language version of the site (en or ru)',
                    'ru' => 'Языковая версия сайта (en или ru)',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Language version of the site (en or ru)',
                    'ru' => 'Языковая версия сайта (en или ru)',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => 'Language version of the site (en or ru)',
                    'ru' => 'Языковая версия сайта (en или ru)',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => 'Language version of the site (en or ru)',
                    'ru' => 'Языковая версия сайта (en или ru)',
                ),
        ));
    }
}
