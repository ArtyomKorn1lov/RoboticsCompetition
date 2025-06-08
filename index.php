<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Главная");
$APPLICATION->SetPageProperty("SHOW_TITLE", "N");
?>
<?php
$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "main",
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_ELEMENT_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BROWSER_TITLE" => "-",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_CODE" => "",
        "ELEMENT_ID" => Robot\Core\Views\Events\EventsView::getActiveEventId(),
        "FIELD_CODE" => array("DETAIL_TEXT", "DETAIL_PICTURE"),
        "IBLOCK_ID" => Robot\Core\Tools\IBlocks\Helper::getIBlock(Robot\Core\Constants::EVENTS_IBLOCK_CODE),
        "IBLOCK_TYPE" => Robot\Core\Constants::CONTENT_IBLOCK_TYPE,
        "IBLOCK_URL" => "",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "MESSAGE_404" => "",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Событие",
        "PROPERTY_CODE" => array("EVENT_DATES", "ACTIVE_REGISTRATION"),
        "SET_BROWSER_TITLE" => "Y",
        "SET_CANONICAL_URL" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "STRICT_SECTION_CHECK" => "N",
        "USE_PERMISSIONS" => "N",
        "USE_SHARE" => "N"
    )
);
?>

<?php
$APPLICATION->IncludeComponent(
    "robot:empty.component",
    "actions",
    Array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "MODULES_CODES" => array("robot.core","")
    )
);?>

<?php
$APPLICATION->IncludeComponent(
    "robot:multiple.include.area",
    "partners",
    Array(
        "INCLUDE_AREA_COUNT" => "3",
        "TITLE" => "",
        "TITLE_CLASS" => "",
        "WRAPPER_CLASS" => "b-section b-section_pb b-section_last b-partners",
        "TITLE_0" => "",
        "TITLE_1" => "",
        "TITLE_2" => "",
        "AREA_FILE_SHOW_0" => "file",
        "AREA_FILE_SHOW_1" => "file",
        "AREA_FILE_SHOW_2" => "file",
        "AREA_FILE_SUFFIX_0" => "",
        "AREA_FILE_SUFFIX_1" => "",
        "AREA_FILE_SUFFIX_3" => "",
        "EDIT_TEMPLATE_0" => "",
        "EDIT_TEMPLATE_1" => "",
        "EDIT_TEMPLATE_2" => "",
        "PATH_0" => SITE_DIR . "include/partners/title.php",
        "PATH_1" => SITE_DIR . "include/partners/description.php",
        "PATH_2" => SITE_DIR . "include/partners/index.php",
        "WRAPPER_CLASS_0" => "b-section__title b-partners__title",
        "WRAPPER_CLASS_1" => "b-section__description",
        "WRAPPER_CLASS_2" => ""
    )
);?>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>