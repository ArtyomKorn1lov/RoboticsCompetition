<?php
//подключаем класс и файлы локализации
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

//добавляем пункт меню для нашего модуля
$menu = array(
    array(
        'parent_menu' => 'global_menu_settings', //определяем место меню, в данном случае оно находится в главном меню
        'sort' => 200,  //сортировка, в каком месте будет находиться наш пункт
        'icon' => 'sys_menu_icon', // малая иконка
        'page_icon' => 'sys_menu_icon', // большая иконка
        'text' => Loc::getMessage('ROBOT_MODULE_TITLE'),   //описание из файла локализации
        'title' => Loc::getMessage('ROBOT_MODULE_TITLE'),  //название из файла локализации
        'url' => 'robot_core_site_settings.php?lang=' . LANGUAGE_ID,  //ссылка на страницу из меню
        'items_id' => 'menu_references',    //описание подпункта, то же, что и ранее, либо другое, можно вставить сколько угодно пунктов меню
    ),
);

return $menu;