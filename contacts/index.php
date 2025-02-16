<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
$APPLICATION->SetPageProperty("SHOW_TITLE", "N");
?>

<div class="b-section b-section_pb b-section_last b-contacts">
    <div class="b-contacts__left">
        <h1 class="b-main__title b-contacts__title">
            <?=$APPLICATION->GetTitle(false, true)?>
        </h1>
        <div class="b-contacts__info">
            <div class="b-contacts__group">
                <span class="b-contacts__subtitle">
                    Адрес организации
                </span>
                <div class="b-contacts__list">
                    <span class="b-contacts__item">
                        <b>1 корпус:</b> Республика Марий Эл, г. Йошкар-Ола, площадь имени В.И. Ленина, 3
                    </span>
                    <span class="b-contacts__item">
                        <b>2 корпус:</b> Республика Марий Эл, г. Йошкар-Ола, ул. Советская, 158
                    </span>
                    <span class="b-contacts__item">
                        <b>3 корпус:</b> Республика Марий Эл, г. Йошкар-Ола, ул. Панфилова, 17
                    </span>
                </div>
            </div>
            <div class="b-contacts__group">
                <span class="b-contacts__subtitle">
                    Телефон
                </span>
                <div class="b-contacts__list">
                    <span class="b-contacts__item">
                        <b>Приемная ректора:</b> <a class="b-contacts__link" href="tel:8362455344">(8362) 45-53-44</a>
                    </span>
                    <span class="b-contacts__item">
                        <b>Отдел кадров:</b> <a class="b-contacts__link" href="tel:8362686811">(8362) 68-68-11</a>
                    </span>
                    <span class="b-contacts__item">
                        <b>Бухгалтерия:</b> <a class="b-contacts__link" href="tel:8362687897">(8362) 68-78-97</a>
                    </span>
                </div>
            </div>
            <div class="b-contacts__group">
                <span class="b-contacts__subtitle">
                    E-mail
                </span>
                <div class="b-contacts__list">
                    <span class="b-contacts__item">
                        <a class="b-contacts__link" href="mailto:competation@mail.com">competation@mail.com</a>
                    </span>
                </div>
            </div>
            <div class="b-contacts__group">
                <span class="b-contacts__subtitle">
                    Telegram-канал
                </span>
                <div class="b-contacts__list">
                    <span class="b-contacts__item">
                        <a href="#" target="_blank" class="b-contacts__icon">
                            <?= Robot\Core\Tools\Template\Helper::getIcon("telegram") ?>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="b-contacts__map">

    </div>
</div>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
