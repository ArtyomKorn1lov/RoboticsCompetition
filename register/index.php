<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");

$array =["templateId" => "test"];
$arJsData = Bitrix\Main\Web\Json::encode($array);
?>
<div id="<?= $array['templateId'] ?>"></div>
<script>
    BX.ready(() => {
        BX.Robot.Components.Vue.Test(<?=$arJsData?>);
    });
</script>
<?php
Bitrix\Main\UI\Extension::load(["robot.components.test"]);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
