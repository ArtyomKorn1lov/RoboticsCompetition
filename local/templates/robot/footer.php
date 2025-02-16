<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    IncludeTemplateLangFile(__FILE__);

global $APPLICATION;

Robot\Core\Tools\Template\Helper::initTitle("b-main__title");
?>
</main>
<footer class="b-footer">

    <?php
    $APPLICATION->IncludeComponent(
        "robot:empty.component",
        "footer_contacts",
        Array(
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "MODULES_CODES" => array("robot.core","")
        )
    );?>

</footer>
</div>
</body>
</html>