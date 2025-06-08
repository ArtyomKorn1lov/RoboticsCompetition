<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Подготовка к проведению соревнований");
?>

<?php
$APPLICATION->IncludeComponent(
    "robot:multiple.include.area",
    "competition",
    Array(
        "INCLUDE_AREA_COUNT" => "2",
        "TITLE" => "",
        "TITLE_CLASS" => "",
        "WRAPPER_CLASS" => "b-section b-section__top_pt_15 b-section_pb_half",
        "TITLE_0" => "",
        "TITLE_1" => "",
        "AREA_FILE_SHOW_0" => "page",
        "AREA_FILE_SHOW_1" => "page",
        "AREA_FILE_SUFFIX_0" => "title",
        "AREA_FILE_SUFFIX_1" => "article",
        "EDIT_TEMPLATE_0" => "",
        "EDIT_TEMPLATE_1" => "",
        "PATH_0" => "",
        "PATH_1" => "",
        "WRAPPER_CLASS_0" => "b-section__top",
        "WRAPPER_CLASS_1" => "b-section__article",
    )
);?>

<?php
$APPLICATION->IncludeComponent(
    "robot:multiple.include.area",
    "competition",
    Array(
        "INCLUDE_AREA_COUNT" => "3",
        "TITLE" => "",
        "TITLE_CLASS" => "",
        "WRAPPER_CLASS" => "b-section b-section_pb b-section_last",
        "TITLE_0" => "",
        "TITLE_1" => "",
        "TITLE_2" => "",
        "AREA_FILE_SHOW_0" => "file",
        "AREA_FILE_SHOW_1" => "file",
        "AREA_FILE_SHOW_2" => "file",
        "AREA_FILE_SUFFIX_0" => "",
        "AREA_FILE_SUFFIX_1" => "",
        "AREA_FILE_SUFFIX_2" => "",
        "EDIT_TEMPLATE_0" => "",
        "EDIT_TEMPLATE_1" => "",
        "EDIT_TEMPLATE_2" => "",
        "PATH_0" => SITE_DIR . "include/prepare-competition/title.php",
        "PATH_1" => SITE_DIR . "include/prepare-competition/description.php",
        "PATH_2" => SITE_DIR . "include/prepare-competition/index.php",
        "WRAPPER_CLASS_0" => "b-section__top",
        "WRAPPER_CLASS_1" => "b-section__description b-section__description_text-normal b-section__description_mb-30",
        "WRAPPER_CLASS_2" => "",
    )
);?>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>