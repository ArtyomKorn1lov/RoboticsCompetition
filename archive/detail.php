<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Фото и видео фестиваля");
$APPLICATION->AddChainItem("Фото и видео фестиваля");

$array =["templateId" => "media-items"];
$arJsData = Bitrix\Main\Web\Json::encode($array);
?>

<div id="<?=$array["templateId"]?>"></div>
<script>
    BX.ready(() => {
        BX.Robot.Components.Vue.MediaItems(<?=$arJsData?>);
    });
</script>

<?php
Bitrix\Main\UI\Extension::load(["robot.components.media-items"]);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
