<?php
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/modules/robot.core/admin/robot_core_site_settings.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/robot.core/admin/robot_core_site_settings.php");
} else {
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/robot.core/admin/robot_core_site_settings.php");
}