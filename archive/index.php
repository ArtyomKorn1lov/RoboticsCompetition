<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Архив");
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

<div class="b-section b-section_pb b-section_last b-archive">
    <div class="b-section__top">
        <h2 class="h5 b-section__title b-archive__subtitle">
            2024 год
        </h2>
    </div>

    <div class="b-archive__list">
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Фотографии с фестиваля
                </span>
                <p class="b-archive__description">
                    Все фотографии сделанные на мероприятии
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Трансляция с фестиваля
                </span>
                <p class="b-archive__description">
                    Трансляция мероприятий
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Фото с олимпиады
                </span>
                <p class="b-archive__description">
                    Все фотографии сделанные на мероприятии
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Фотографии с фестиваля
                </span>
                <p class="b-archive__description">
                    Все фотографии сделанные на мероприятии
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Трансляция с фестиваля
                </span>
                <p class="b-archive__description">
                    Трансляция мероприятий
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
    </div>

    <div class="b-section__top">
        <h2 class="h5 b-section__title b-archive__subtitle">
            2023 год
        </h2>
    </div>

    <div class="b-archive__list">
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Фотографии с фестиваля
                </span>
                <p class="b-archive__description">
                    Все фотографии сделанные на мероприятии
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Трансляция с фестиваля
                </span>
                <p class="b-archive__description">
                    Трансляция мероприятий
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Фото с олимпиады
                </span>
                <p class="b-archive__description">
                    Все фотографии сделанные на мероприятии
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Фотографии с фестиваля
                </span>
                <p class="b-archive__description">
                    Все фотографии сделанные на мероприятии
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
    </div>

    <div class="b-section__top">
        <h2 class="h5 b-section__title b-archive__subtitle">
            2022 год
        </h2>
    </div>

    <div class="b-archive__list">
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Фотографии с фестиваля
                </span>
                <p class="b-archive__description">
                    Все фотографии сделанные на мероприятии
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Трансляция с фестиваля
                </span>
                <p class="b-archive__description">
                    Трансляция мероприятий
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
        <a href="/archive/detail.php" class="b-archive__item">
            <div class="b-archive__left">
                <span class="h6 b-archive__name">
                    Фото с олимпиады
                </span>
                <p class="b-archive__description">
                    Все фотографии сделанные на мероприятии
                </p>
            </div>
            <span class="b-archive__icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("arrow_right") ?>
            </span>
        </a>
    </div>
</div>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>