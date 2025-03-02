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
        "IBLOCK_ID" => Robot\Core\Tools\IBlocks\Helper::getIblock(Robot\Core\Constants::EVENTS_IBLOCK_CODE),
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

<!-- TODO Сделать множественную включаемую область -->
<div class="b-section b-section_pb b-section_last b-partners">
    <h2 class="b-section__title b-partners__title">Организаторы</h2>
    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "custom_wrapper",
        array(
            "CUSTOM_WRAPPER_START" => '<p class="b-section__description">',
            "CUSTOM_WRAPPER_END" => '</p>',
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR."include/partners/index_description.php",
            "AREA_FILE_RECURSIVE" => "Y",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "standard.php"
        ),
        false
    ); ?>
    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        ".default",
        array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR."include/partners/index.php",
            "AREA_FILE_RECURSIVE" => "Y",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "standard.php"
        ),
        false
    ); ?>
</div>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>