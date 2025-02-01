<?php

namespace Sprint\Migration;


class ContentIBlockType20250201141509 extends Version
{
    protected $author = "admin";

    protected $description = "Типы ИБ \"Контент\" и \"Обратная связь\"";

    protected $moduleVersion = "4.18.0";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Iblock()->saveIblockType(array(
            'ID' => 'content',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => '100',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Контент',
                            'SECTION_NAME' => 'Контент',
                            'ELEMENT_NAME' => 'Контент',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Content',
                            'SECTION_NAME' => 'Content',
                            'ELEMENT_NAME' => 'Content',
                        ),
                ),
        ));
        $helper->Iblock()->saveIblockType(array(
            'ID' => 'feedback',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => '200',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Обратная связь',
                            'SECTION_NAME' => 'Обратная связь',
                            'ELEMENT_NAME' => 'Обратная связь',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Обратная связь',
                            'SECTION_NAME' => 'Обратная связь',
                            'ELEMENT_NAME' => 'Обратная связь',
                        ),
                ),
        ));
    }
}
