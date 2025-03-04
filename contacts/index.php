<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
$APPLICATION->SetPageProperty("SHOW_TITLE", "N");
?>

<?php
$APPLICATION->IncludeComponent(
    "robot:empty.component",
    "contacts",
    Array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "MODULES_CODES" => array("robot.core","")
    )
);?>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
