<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Preparation for the competition");
?>

<div class="b-section b-section__top_pt_15 b-section_pb_half">
    <div class="b-section__top">
        <h4 class="b-section__title">
            Equipment requirements
        </h4>
    </div>
    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "custom_wrapper",
        array(
            "CUSTOM_WRAPPER_START" => '<div class="b-section__article">',
            "CUSTOM_WRAPPER_END" => '</div>',
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR."include/prepare-competition/article.php",
            "AREA_FILE_RECURSIVE" => "Y",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "standard.php"
        ),
        false
    ); ?>
</div>

<!-- TODO Сделать множественную включаемую область -->
<div class="b-section b-section_pb b-section_last">
    <div class="b-section__top">
        <h4 class="b-section__title">
            Equipment requirements
        </h4>
    </div>
    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "custom_wrapper",
        array(
            "CUSTOM_WRAPPER_START" => '<div class="b-section__description b-section__description_text-normal b-section__description_mb-30">',
            "CUSTOM_WRAPPER_END" => '</div>',
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR."include/prepare-competition/index_description.php",
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
            "PATH" => SITE_DIR."include/prepare-competition/index.php",
            "AREA_FILE_RECURSIVE" => "Y",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "standard.php"
        ),
        false
    ); ?>
</div>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>