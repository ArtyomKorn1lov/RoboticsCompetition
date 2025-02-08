<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    IncludeTemplateLangFile(__FILE__);
?>
</main>
<footer class="b-footer">

    <div class="b-footer__wrap">
        <div class="b-footer__logo">
            <a class="b-footer__logo-wrap" href="<?=SITE_DIR?>">
                <img class="b-footer__logo-icon" src="<?=SITE_DIR?>local/templates/robot/app/img/logo_footer.svg" alt="Соревнования по робототехнике в ПГТУ">
            </a>
            <div class="b-footer__title-wrap">
                <div class="b-footer__title">
                    Соревнования по робототехнике в ПГТУ
                </div>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "custom_wrapper",
                    array(
                        "CUSTOM_WRAPPER_START" => '<span class="b-footer__copyright">',
                        "CUSTOM_WRAPPER_END" => '</span>',
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/copyright.php",
                        "AREA_FILE_RECURSIVE" => "Y",
                        "COMPONENT_TEMPLATE" => ".default",
                        "EDIT_TEMPLATE" => "standard.php"
                    ),
                    false
                ); ?>
            </div>
        </div>

        <div class="b-footer__contact">
            <a href="mailto:competation@mail.com" class="b-footer__contact-item b-footer__contact-item_link">
                <span class="b-footer__contact-icon">
                    <svg>
                        <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#mail_footer"></use>
                    </svg>
                </span>
                <span class="b-footer__contact-label">
                    competation@mail.com
                </span>
            </a>
            <a href="tel:+79876543210" class="b-footer__contact-item b-footer__contact-item_link">
                <span class="b-footer__contact-icon">
                    <svg>
                        <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#phone_footer"></use>
                    </svg>
                </span>
                <span class="b-footer__contact-label">
                    +7 (987) 654-32-10
                </span>
            </a>
        </div>

        <div class="b-footer__contact">
            <div class="b-footer__contact-item">
                <span class="b-footer__contact-icon">
                    <svg>
                        <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#address_footer"></use>
                    </svg>
                </span>
                <span class="b-footer__contact-label b-footer__contact-label_description">
                    Республика Марий Эл, г. Йошкар-Ола, площадь имени В.И. Ленина, 3
                </span>
            </div>
            <div class="b-footer__contact-item b-footer__contact-item_social">
                <span class="b-footer__contact-label b-footer__contact-label_social">
                    Соц сети:
                </span>
                <a href="#" class="b-footer__contact-icon b-footer__contact-icon_social">
                    <svg>
                        <use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#telegram_footer"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>

</footer>
</div>
</body>
</html>