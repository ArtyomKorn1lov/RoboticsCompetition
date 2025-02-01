<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    IncludeTemplateLangFile(__FILE__);
?>
</main>
<footer>

    <!-- Логотип в футере -->
    <a href="<?=SITE_DIR?>">
        <img width="150" src="<?=SITE_DIR?>local/templates/robot/app/img/logo.webp" alt="logo">
    </a>
    <!-- !Логотип в футере -->

    <!-- Контактная информация в футере -->
    <ul>
        <li>
            <a href="tel:+79999999999">8 (999) 999-99-99</a>
            <a href="tel:+79999999999">8 (999) 999-99-99</a>
        </li>
        <li>
            424000, Республика Марий Эл, г. Йошкар-Ола, пл. Ленина, дом 3.
        </li>
        <li>
            <a href="#">Мы в телеграмм!</a>
        </li>
    </ul>
    <!-- !Контактная информация в футере -->

    <!-- Копирайт -->
    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        ".default",
        array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR."include/copyright.php",
            "AREA_FILE_RECURSIVE" => "Y",
            "COMPONENT_TEMPLATE" => ".default",
            "EDIT_TEMPLATE" => "standard.php"
        ),
        false
    ); ?>
    <!-- !Копирайт -->

</footer>
</body>
</html>