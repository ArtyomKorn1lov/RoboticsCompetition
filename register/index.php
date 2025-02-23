<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");

$array =["templateId" => "registration"];
$arJsData = Bitrix\Main\Web\Json::encode($array);
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

<div class="b-section b-section_pb b-section_last">
    <div class="b-registration">
        <div class="b-registration__form" id="<?=$array["templateId"]?>"></div>
        <div class="b-registration__banner-wrap">
            <img class="b-registration__banner" src="<?=SITE_DIR?>local/templates/robot/app/img/registration_banner.webp" alt="Регистрация">
        </div>
    </div>
</div>
<script>
    BX.ready(() => {
        BX.Robot.Components.Vue.Registration(<?=$arJsData?>);
    });
</script>
<?php
Bitrix\Main\UI\Extension::load(["robot.components.registration"]);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
