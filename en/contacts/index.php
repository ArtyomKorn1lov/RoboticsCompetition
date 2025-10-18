<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Contacts");
$APPLICATION->SetPageProperty("SHOW_TITLE", "N");
?>

<?php
$APPLICATION->IncludeComponent(
    "robot:template.component",
    "contacts",
    Array(
        "MODULES_CODES" => array("robot.core","")
    )
);?>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
