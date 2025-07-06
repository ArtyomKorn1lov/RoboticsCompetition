<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Robot\Core\Tools\Files\Helper;
use Robot\Core\Constants;

$photos = [];
if (!empty($arResult["DISPLAY_PROPERTIES"]["PHOTO"]["FILE_VALUE"])) {
    $photoProperty = $arResult["DISPLAY_PROPERTIES"]["PHOTO"]["FILE_VALUE"];

    if (isset($photoProperty["ID"])) {
        $photos[] = [
            "name" => $arResult["NAME"],
            "url" => $photoProperty["SRC"],
            "isVideo" => false
        ];
    } else {
        foreach ($photoProperty as $item) {
            $photos[] = [
                "name" => $arResult["NAME"],
                "url" => $item["SRC"],
                "isVideo" => false
            ];
        }
    }
}

$fileHelper = new Helper();

$videos = [];
if (!empty($arResult["DISPLAY_PROPERTIES"]["VIDEO_LINKS"]["VALUE"])) {
    $links = $arResult["DISPLAY_PROPERTIES"]["VIDEO_LINKS"]["VALUE"];
    $videoPreviews = $arResult["DISPLAY_PROPERTIES"]["VIDEO_PREVIEW"]["FILE_VALUE"];

    foreach ($links as $key => $link) {
        $preview = false;
        if (!empty($videoPreviews)) {
            $preview = $fileHelper->getFilePreviewByIndex($videoPreviews, $key);
            if (!empty($preview)) {
                unset($arResult["DISPLAY_PROPERTIES"]["VIDEO_PREVIEW"]["FILE_VALUE"][$key]);
            }
        }

        $videos[] = [
            "name" => $arResult["NAME"],
            "url" => $fileHelper->getEmbedVideo($link),
            "preview" => !empty($videoPreviews) ? $fileHelper->getFilePreviewByIndex($videoPreviews, $key) : false,
            "type" => Constants::EMBED_VIDEO_TYPES,
            "isVideo" => true
        ];
    }
}



if (!empty($arResult["DISPLAY_PROPERTIES"]["VIDEO"]["FILE_VALUE"])) {
    $videoProperty = $arResult["DISPLAY_PROPERTIES"]["VIDEO"]["FILE_VALUE"];
    $videoPreviews = $arResult["DISPLAY_PROPERTIES"]["VIDEO_PREVIEW"]["FILE_VALUE"];
    if (!empty($videoPreviews)) {
        $videoPreviews = array_values($videoPreviews);
    }

    if (isset($videoProperty["ID"])) {
        $videos[] = [
            "name" => $arResult["NAME"],
            "url" => $videoProperty["SRC"],
            "preview" => !empty($videoPreviews) ? $fileHelper->getFilePreviewByIndex($videoPreviews, 0) : false,
            "type" => $videoProperty["CONTENT_TYPE"],
            "isVideo" => true
        ];
    } else {
        foreach ($videoProperty as $key => $item) {
            $videos[] = [
                "name" => $arResult["NAME"],
                "url" => $item["SRC"],
                "preview" => !empty($videoPreviews) ? $fileHelper->getFilePreviewByIndex($videoPreviews, $key) : false,
                "type" => $item["CONTENT_TYPE"],
                "isVideo" => true
            ];
        }
    }
}

$arResult["JS_DATA"] = [
    "photos" => $photos,
    "videos" => $videos
];
