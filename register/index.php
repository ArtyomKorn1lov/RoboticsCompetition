<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");

use Bitrix\Iblock\Component\Tools;
use Robot\Core\Views\Events\EventsView;

if (!EventsView::showRegistration()) {
    Tools::process404('', true, true, true, SITE_DIR . '404.php');
    return;
}

?>
<?php $APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "description_page",
    array(
        "DESCRIPTION_CLASS" => "b-section__description_mb-35",
        "AREA_FILE_SHOW" => "page",
        "AREA_FILE_SUFFIX" => "description",
        "AREA_FILE_RECURSIVE" => "Y",
        "COMPONENT_TEMPLATE" => ".default",
        "EDIT_TEMPLATE" => "standard.php"
    ),
    false
); ?>

<?php
$APPLICATION->IncludeComponent(
    "robot:empty.component",
    "registration",
    Array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "MODULES_CODES" => array("robot.core","")
    )
);?>
<?php
Bitrix\Main\UI\Extension::load(["robot.components.registration"]);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
