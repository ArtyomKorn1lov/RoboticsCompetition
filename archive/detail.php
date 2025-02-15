<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Фото и видео фестиваля");
$APPLICATION->AddChainItem("Фото и видео фестиваля");
?>

<div class="b-section b-section_pb b-section_last b-archive">

    <div class="b-section__top">
        <h2 class="h5 b-section__title b-archive__subtitle">
            Фотографии
        </h2>
    </div>
    <div class="b-materials b-materials_mb">
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_1.webp" alt="Фото фестиваля 1">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_2.webp" alt="Фото фестиваля 2">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_3.webp" alt="Фото фестиваля 3">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_4.webp" alt="Фото фестиваля 4">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_1.webp" alt="Фото фестиваля 1">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_2.webp" alt="Фото фестиваля 2">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_3.webp" alt="Фото фестиваля 3">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_4.webp" alt="Фото фестиваля 4">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_1.webp" alt="Фото фестиваля 1">
        </a>
        <a class="b-materials__img-wrap" href="javascript:void(0)">
            <img class="b-materials__img" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_photo_2.webp" alt="Фото фестиваля 2">
        </a>
    </div>

    <div class="b-section__top">
        <h2 class="h5 b-section__title b-archive__subtitle">
            Видео
        </h2>
    </div>
    <div class="b-materials b-materials_video">
        <a class="b-materials__video-wrap" href="javascript:void(0)">
            <img class="b-materials__video" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_video_1.webp" alt="Видео фестиваля 1">
            <div class="b-materials__video-icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("play"); ?>
            </div>
        </a>
        <a class="b-materials__video-wrap" href="javascript:void(0)">
            <img class="b-materials__video" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_video_1.webp" alt="Видео фестиваля 1">
            <div class="b-materials__video-icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("play"); ?>
            </div>
        </a>
        <a class="b-materials__video-wrap" href="javascript:void(0)">
            <img class="b-materials__video" src="<?=SITE_DIR?>local/templates/robot/app/img/archive_video_1.webp" alt="Видео фестиваля 1">
            <div class="b-materials__video-icon">
                <?= Robot\Core\Tools\Template\Helper::getIcon("play"); ?>
            </div>
        </a>
    </div>

</div>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
