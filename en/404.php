<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Page not found");
$APPLICATION->SetPageProperty("SHOW_TITLE", "N");
?>

<?php
$APPLICATION->IncludeComponent(
    "robot:empty.component",
    "empty",
    Array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "MODULES_CODES" => []
    )
);?>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>