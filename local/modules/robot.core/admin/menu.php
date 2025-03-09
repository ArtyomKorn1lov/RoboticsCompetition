<?php
//подключаем класс и файлы локализации
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

//добавляем пункт меню для нашего модуля
$menu = array(
    array(
        'parent_menu' => 'global_menu_content', //определяем место меню, в данном случае оно находится в главном меню
        'sort' => 400,  //сортировка, в каком месте будет находится наш пункт
        'text' => Loc::getMessage('MAIN_MODULE_TITLE'),   //описание из файла локализации
        'title' => Loc::getMessage('MAIN_MODULE_TITLE'),  //название из файла локализации
        'url' => 'robot_core_site_settings.php?lang=' . LANGUAGE_ID,  //ссылка на страницу из меню
        'items_id' => 'menu_references',    //описание подпункта, то же, что и ранее, либо другое, можно вставить сколько угодно пунктов меню
    ),
);

return $menu;