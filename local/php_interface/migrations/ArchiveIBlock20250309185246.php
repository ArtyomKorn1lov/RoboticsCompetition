<?php

namespace Sprint\Migration;


class ArchiveIBlock20250309185246 extends Version
{
    protected $author = "admin";

    protected $description = "ИБ \"Архив\"";

    protected $moduleVersion = "4.18.0";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->saveIblock(array(
            'IBLOCK_TYPE_ID' => 'robot_content',
            'LID' =>
                array(
                    0 => 's1',
                ),
            'CODE' => 'archive',
            'API_CODE' => NULL,
            'REST_ON' => 'N',
            'NAME' => 'Архив',
            'ACTIVE' => 'Y',
            'SORT' => '700',
            'LIST_PAGE_URL' => '#SITE_DIR#/archive/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/archive/#ELEMENT_CODE#/',
            'SECTION_PAGE_URL' => '#SITE_DIR#/archive/#SECTION_CODE#/',
            'CANONICAL_PAGE_URL' => '',
            'PICTURE' => NULL,
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
            'RSS_TTL' => '24',
            'RSS_ACTIVE' => 'Y',
            'RSS_FILE_ACTIVE' => 'N',
            'RSS_FILE_LIMIT' => NULL,
            'RSS_FILE_DAYS' => NULL,
            'RSS_YANDEX_ACTIVE' => 'N',
            'XML_ID' => '79b78015-56ea-4725-91fd-ddead7b6aa9f',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'SECTION_CHOOSER' => 'L',
            'LIST_MODE' => 'C',
            'RIGHTS_MODE' => 'S',
            'SECTION_PROPERTY' => 'N',
            'PROPERTY_INDEX' => 'N',
            'VERSION' => '1',
            'LAST_CONV_ELEMENT' => '0',
            'SOCNET_GROUP_ID' => NULL,
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'SECTIONS_NAME' => 'Разделы',
            'SECTION_NAME' => 'Раздел',
            'ELEMENTS_NAME' => 'Элементы',
            'ELEMENT_NAME' => 'Элемент',
            'EXTERNAL_ID' => '79b78015-56ea-4725-91fd-ddead7b6aa9f',
            'LANG_DIR' => '/',
            'IPROPERTY_TEMPLATES' =>
                array(),
            'ELEMENT_ADD' => 'Добавить элемент',
            'ELEMENT_EDIT' => 'Изменить элемент',
            'ELEMENT_DELETE' => 'Удалить элемент',
            'SECTION_ADD' => 'Добавить раздел',
            'SECTION_EDIT' => 'Изменить раздел',
            'SECTION_DELETE' => 'Удалить раздел',
        ));
        $helper->Iblock()->saveIblockFields($iblockId, array(
            'IBLOCK_SECTION' =>
                array(
                    'NAME' => 'Привязка к разделам',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' =>
                        array(
                            'KEEP_IBLOCK_SECTION_ID' => 'N',
                        ),
                    'VISIBLE' => 'Y',
                ),
            'ACTIVE' =>
                array(
                    'NAME' => 'Активность',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => 'Y',
                    'VISIBLE' => 'Y',
                ),
            'ACTIVE_FROM' =>
                array(
                    'NAME' => 'Начало активности',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'ACTIVE_TO' =>
                array(
                    'NAME' => 'Окончание активности',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'SORT' =>
                array(
                    'NAME' => 'Сортировка',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => '500',
                    'VISIBLE' => 'Y',
                ),
            'NAME' =>
                array(
                    'NAME' => 'Название',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'PREVIEW_PICTURE' =>
                array(
                    'NAME' => 'Картинка для анонса',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' =>
                        array(
                            'FROM_DETAIL' => 'N',
                            'UPDATE_WITH_DETAIL' => 'N',
                            'DELETE_WITH_DETAIL' => 'N',
                            'SCALE' => 'N',
                            'WIDTH' => '',
                            'HEIGHT' => '',
                            'IGNORE_ERRORS' => 'N',
                            'METHOD' => 'resample',
                            'COMPRESSION' => 95,
                            'USE_WATERMARK_TEXT' => 'N',
                            'WATERMARK_TEXT' => '',
                            'WATERMARK_TEXT_FONT' => '',
                            'WATERMARK_TEXT_COLOR' => '',
                            'WATERMARK_TEXT_SIZE' => '',
                            'WATERMARK_TEXT_POSITION' => 'tl',
                            'USE_WATERMARK_FILE' => 'N',
                            'WATERMARK_FILE' => '',
                            'WATERMARK_FILE_ALPHA' => '',
                            'WATERMARK_FILE_POSITION' => 'tl',
                            'WATERMARK_FILE_ORDER' => '',
                        ),
                    'VISIBLE' => 'Y',
                ),
            'PREVIEW_TEXT_TYPE' =>
                array(
                    'NAME' => 'Тип описания для анонса',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => 'text',
                    'VISIBLE' => 'Y',
                ),
            'PREVIEW_TEXT' =>
                array(
                    'NAME' => 'Описание для анонса',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'DETAIL_PICTURE' =>
                array(
                    'NAME' => 'Детальная картинка',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' =>
                        array(
                            'SCALE' => 'N',
                            'WIDTH' => '',
                            'HEIGHT' => '',
                            'IGNORE_ERRORS' => 'N',
                            'METHOD' => 'resample',
                            'COMPRESSION' => 95,
                            'USE_WATERMARK_TEXT' => 'N',
                            'WATERMARK_TEXT' => '',
                            'WATERMARK_TEXT_FONT' => '',
                            'WATERMARK_TEXT_COLOR' => '',
                            'WATERMARK_TEXT_SIZE' => '',
                            'WATERMARK_TEXT_POSITION' => 'tl',
                            'USE_WATERMARK_FILE' => 'N',
                            'WATERMARK_FILE' => '',
                            'WATERMARK_FILE_ALPHA' => '',
                            'WATERMARK_FILE_POSITION' => 'tl',
                            'WATERMARK_FILE_ORDER' => '',
                        ),
                    'VISIBLE' => 'Y',
                ),
            'DETAIL_TEXT_TYPE' =>
                array(
                    'NAME' => 'Тип детального описания',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => 'text',
                    'VISIBLE' => 'Y',
                ),
            'DETAIL_TEXT' =>
                array(
                    'NAME' => 'Детальное описание',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'XML_ID' =>
                array(
                    'NAME' => 'Внешний код',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'CODE' =>
                array(
                    'NAME' => 'Символьный код',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' =>
                        array(
                            'UNIQUE' => 'N',
                            'TRANSLITERATION' => 'Y',
                            'TRANS_LEN' => 100,
                            'TRANS_CASE' => 'L',
                            'TRANS_SPACE' => '-',
                            'TRANS_OTHER' => '-',
                            'TRANS_EAT' => 'Y',
                            'USE_GOOGLE' => 'N',
                        ),
                    'VISIBLE' => 'Y',
                ),
            'TAGS' =>
                array(
                    'NAME' => 'Теги',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'SECTION_NAME' =>
                array(
                    'NAME' => 'Название',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'SECTION_PICTURE' =>
                array(
                    'NAME' => 'Картинка для анонса',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' =>
                        array(
                            'FROM_DETAIL' => 'N',
                            'UPDATE_WITH_DETAIL' => 'N',
                            'DELETE_WITH_DETAIL' => 'N',
                            'SCALE' => 'N',
                            'WIDTH' => '',
                            'HEIGHT' => '',
                            'IGNORE_ERRORS' => 'N',
                            'METHOD' => 'resample',
                            'COMPRESSION' => 95,
                            'USE_WATERMARK_TEXT' => 'N',
                            'WATERMARK_TEXT' => '',
                            'WATERMARK_TEXT_FONT' => '',
                            'WATERMARK_TEXT_COLOR' => '',
                            'WATERMARK_TEXT_SIZE' => '',
                            'WATERMARK_TEXT_POSITION' => 'tl',
                            'USE_WATERMARK_FILE' => 'N',
                            'WATERMARK_FILE' => '',
                            'WATERMARK_FILE_ALPHA' => '',
                            'WATERMARK_FILE_POSITION' => 'tl',
                            'WATERMARK_FILE_ORDER' => '',
                        ),
                    'VISIBLE' => 'Y',
                ),
            'SECTION_DESCRIPTION_TYPE' =>
                array(
                    'NAME' => 'Тип описания',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => 'text',
                    'VISIBLE' => 'Y',
                ),
            'SECTION_DESCRIPTION' =>
                array(
                    'NAME' => 'Описание',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'SECTION_DETAIL_PICTURE' =>
                array(
                    'NAME' => 'Детальная картинка',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' =>
                        array(
                            'SCALE' => 'N',
                            'WIDTH' => '',
                            'HEIGHT' => '',
                            'IGNORE_ERRORS' => 'N',
                            'METHOD' => 'resample',
                            'COMPRESSION' => 95,
                            'USE_WATERMARK_TEXT' => 'N',
                            'WATERMARK_TEXT' => '',
                            'WATERMARK_TEXT_FONT' => '',
                            'WATERMARK_TEXT_COLOR' => '',
                            'WATERMARK_TEXT_SIZE' => '',
                            'WATERMARK_TEXT_POSITION' => 'tl',
                            'USE_WATERMARK_FILE' => 'N',
                            'WATERMARK_FILE' => '',
                            'WATERMARK_FILE_ALPHA' => '',
                            'WATERMARK_FILE_POSITION' => 'tl',
                            'WATERMARK_FILE_ORDER' => '',
                        ),
                    'VISIBLE' => 'Y',
                ),
            'SECTION_XML_ID' =>
                array(
                    'NAME' => 'Внешний код',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => '',
                    'VISIBLE' => 'Y',
                ),
            'SECTION_CODE' =>
                array(
                    'NAME' => 'Символьный код',
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' =>
                        array(
                            'UNIQUE' => 'N',
                            'TRANSLITERATION' => 'Y',
                            'TRANS_LEN' => 100,
                            'TRANS_CASE' => 'L',
                            'TRANS_SPACE' => '-',
                            'TRANS_OTHER' => '-',
                            'TRANS_EAT' => 'Y',
                            'USE_GOOGLE' => 'N',
                        ),
                    'VISIBLE' => 'Y',
                ),
            'LOG_SECTION_ADD' =>
                array(
                    'NAME' => 'LOG_SECTION_ADD',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => NULL,
                    'VISIBLE' => 'Y',
                ),
            'LOG_SECTION_EDIT' =>
                array(
                    'NAME' => 'LOG_SECTION_EDIT',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => NULL,
                    'VISIBLE' => 'Y',
                ),
            'LOG_SECTION_DELETE' =>
                array(
                    'NAME' => 'LOG_SECTION_DELETE',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => NULL,
                    'VISIBLE' => 'Y',
                ),
            'LOG_ELEMENT_ADD' =>
                array(
                    'NAME' => 'LOG_ELEMENT_ADD',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => NULL,
                    'VISIBLE' => 'Y',
                ),
            'LOG_ELEMENT_EDIT' =>
                array(
                    'NAME' => 'LOG_ELEMENT_EDIT',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => NULL,
                    'VISIBLE' => 'Y',
                ),
            'LOG_ELEMENT_DELETE' =>
                array(
                    'NAME' => 'LOG_ELEMENT_DELETE',
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => NULL,
                    'VISIBLE' => 'Y',
                ),
        ));
        $helper->Iblock()->saveGroupPermissions($iblockId, array(
            'administrators' => 'X',
            'everyone' => 'R',
        ));
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Фото',
            'ACTIVE' => 'Y',
            'SORT' => '100',
            'CODE' => 'PHOTO',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'F',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'Y',
            'XML_ID' => 'cddc75db-b5b4-4eef-8b3d-b76bd4b51098',
            'FILE_TYPE' => 'jpg, gif, bmp, png, jpeg, webp',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => NULL,
            'USER_TYPE_SETTINGS' => 'a:0:{}',
            'HINT' => '',
            'FEATURES' =>
                array(
                    0 =>
                        array(
                            'MODULE_ID' => 'iblock',
                            'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                            'IS_ENABLED' => 'N',
                        ),
                    1 =>
                        array(
                            'MODULE_ID' => 'iblock',
                            'FEATURE_ID' => 'LIST_PAGE_SHOW',
                            'IS_ENABLED' => 'N',
                        ),
                ),
        ));
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Превью для видео',
            'ACTIVE' => 'Y',
            'SORT' => '200',
            'CODE' => 'VIDEO_PREVIEW',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'F',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'Y',
            'XML_ID' => '3cba6170-1eff-4995-aaf1-6d6ccd78f7eb',
            'FILE_TYPE' => 'jpg, gif, bmp, png, jpeg, webp',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => NULL,
            'USER_TYPE_SETTINGS' => 'a:0:{}',
            'HINT' => 'Загруженные превью для видео в том же порядке, что и видео-файлы',
            'FEATURES' =>
                array(
                    0 =>
                        array(
                            'MODULE_ID' => 'iblock',
                            'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                            'IS_ENABLED' => 'N',
                        ),
                    1 =>
                        array(
                            'MODULE_ID' => 'iblock',
                            'FEATURE_ID' => 'LIST_PAGE_SHOW',
                            'IS_ENABLED' => 'N',
                        ),
                ),
        ));
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Видео',
            'ACTIVE' => 'Y',
            'SORT' => '300',
            'CODE' => 'VIDEO',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'F',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'Y',
            'XML_ID' => 'd865d391-9690-4538-a3bd-7f612b04e82c',
            'FILE_TYPE' => 'mp4, webm, mov',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'Y',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => NULL,
            'USER_TYPE_SETTINGS' => 'a:0:{}',
            'HINT' => '',
            'FEATURES' =>
                array(
                    0 =>
                        array(
                            'MODULE_ID' => 'iblock',
                            'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                            'IS_ENABLED' => 'N',
                        ),
                    1 =>
                        array(
                            'MODULE_ID' => 'iblock',
                            'FEATURE_ID' => 'LIST_PAGE_SHOW',
                            'IS_ENABLED' => 'N',
                        ),
                ),
        ));
        $helper->UserOptions()->saveElementForm($iblockId, array(
            'Параметры|edit1' =>
                array(
                    'ID' => 'ID',
                    'DATE_CREATE' => 'Создан',
                    'TIMESTAMP_X' => 'Изменен',
                    'ACTIVE' => 'Активность',
                    'NAME' => 'Название',
                    'CODE' => 'Символьный код',
                    'XML_ID' => 'Внешний код',
                    'SORT' => 'Сортировка',
                    'PREVIEW_TEXT' => 'Описание',
                    'PROPERTY_PHOTO' => 'Фото',
                    'PROPERTY_VIDEO_PREVIEW' => 'Превью для видео',
                    'PROPERTY_VIDEO' => 'Видео',
                ),
            'Разделы|edit2' =>
                array(
                    'SECTIONS' => 'Разделы',
                ),
        ));
        $helper->UserOptions()->saveSectionForm($iblockId, array(
            'Раздел|edit1' =>
                array(
                    'ID' => 'ID',
                    'DATE_CREATE' => 'Создан',
                    'TIMESTAMP_X' => 'Изменен',
                    'ACTIVE' => 'Раздел активен',
                    'NAME' => 'Название',
                    'CODE' => 'Символьный код',
                    'XML_ID' => 'Внешний код',
                    'SORT' => 'Сортировка',
                    'IBLOCK_SECTION_ID' => 'Родительский раздел',
                ),
        ));
        $helper->UserOptions()->saveElementGrid($iblockId, array(
            'views' =>
                array(
                    'default' =>
                        array(
                            'columns' =>
                                array(
                                    0 => '',
                                ),
                            'columns_sizes' =>
                                array(
                                    'expand' => 1,
                                    'columns' =>
                                        array(),
                                ),
                            'sticked_columns' =>
                                array(),
                            'custom_names' =>
                                array(),
                        ),
                ),
            'filters' =>
                array(),
            'current_view' => 'default',
        ));

    }
}
