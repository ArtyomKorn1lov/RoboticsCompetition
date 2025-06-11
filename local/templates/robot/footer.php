<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
    IncludeTemplateLangFile(__FILE__);

global $APPLICATION;
use Bitrix\Main\UI\Extension;

Robot\Core\Tools\Template\Helper::initTitle("b-main__title");

// Плагины с основным frontend шаблона подключаются тут, чтобы перегрузить стили js-extention
Extension::load([
    "robot_frontend",
    "jquery"
]);
?>
</main>
<footer class="b-footer">

    <?php
    $APPLICATION->IncludeComponent(
        "robot:template.component",
        "footer_contacts",
        Array(
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "IS_MAIN_PAGE" => ($APPLICATION->GetCurPage(false) === SITE_DIR),
            "MODULES_CODES" => array("robot.core","")
        )
    );?>

</footer>
</div>
</body>
</html>