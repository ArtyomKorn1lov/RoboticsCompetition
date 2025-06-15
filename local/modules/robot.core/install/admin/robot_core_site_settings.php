<?php
$localFilePath = $_SERVER["DOCUMENT_ROOT"] . "/local/modules/robot.core/admin/robot_core_site_settings.php";
if (file_exists($localFilePath)) {
    require_once($localFilePath);
} else {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/robot.core/admin/robot_core_site_settings.php");
}