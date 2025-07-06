<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\IO\InvalidPathException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;

use Robot\Core\DTO\Include\FileCollection;
use Robot\Core\DTO\Include\File;

Loc::loadMessages(__FILE__);

/**
 * Компонент - множественная включаемая область
 * Частично исходный код взят с компонента main.include, добавлена только поддержка через цикл валидации множества файлов и добавление визуального редактора для множества файлов
 */
class IncludeAreaMultipleComponent extends CBitrixComponent
{
    /** @var FileCollection сформированная коллекция файлов для работы компонента */
    private FileCollection $files;

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return array
     * @throws LoaderException
     * @throws InvalidPathException
     */
    public function onPrepareComponentParams($arParams): array
    {
        if (!Bitrix\Main\Loader::includeModule('robot.core')) {
            throw new LoaderException(Loc::getMessage("MAIN_INCLUDE_AREA_ERROR_INCLUDE_CORE"));
        }

        global $APPLICATION;
        $sRealFilePath = $_SERVER["REAL_FILE_PATH"] ?? '';

        $io = CBXVirtualIo::GetInstance();

        $arParams["INCLUDE_AREA_COUNT"] = (int)$arParams["INCLUDE_AREA_COUNT"];

        $this->files = new FileCollection();

        for ($count = 0; $count < $arParams["INCLUDE_AREA_COUNT"]; $count++) {

            $arParams["EDIT_TEMPLATE_" . $count] = ($arParams["EDIT_TEMPLATE_" . $count] ?? '') <> '' ? $arParams["EDIT_TEMPLATE_" . $count] : $arParams["AREA_FILE_SHOW_" . $count] . "_inc.php";
            $bHasPath = ($arParams["AREA_FILE_SHOW_" . $count] == "file");

            if (!$bHasPath) {
                $arParams["AREA_FILE_SHOW_" . $count] = $arParams["AREA_FILE_SHOW_" . $count] == "sect" ? "sect" : "page";
                $arParams["AREA_FILE_SUFFIX_" . $count] = strlen($arParams["AREA_FILE_SUFFIX_" . $count]) > 0 ? $arParams["AREA_FILE_SUFFIX_" . $count] : "inc";
                $arParams["AREA_FILE_RECURSIVE_" . $count] = $arParams["AREA_FILE_RECURSIVE_" . $count] == "N" ? "N" : "Y";

                if ($arParams["AREA_FILE_SHOW_" . $count] == "page") {
                    if ($sRealFilePath <> '') {
                        $slash_pos = mb_strrpos($sRealFilePath, "/");
                        $sFilePath = mb_substr($sRealFilePath, 0, $slash_pos + 1);
                        $sFileName = mb_substr($sRealFilePath, $slash_pos + 1);
                        $sFileName = mb_substr($sFileName, 0, mb_strlen($sFileName) - 4) . "_" . $arParams["AREA_FILE_SUFFIX_" . $count] . ".php";
                    } else {
                        $sFilePath = $APPLICATION->GetCurDir();
                        $sFileName = mb_substr($APPLICATION->GetCurPage(true), 0, mb_strlen($APPLICATION->GetCurPage(true)) - 4) . "_" . $arParams["AREA_FILE_SUFFIX_" . $count] . ".php";
                        $sFileName = mb_substr($sFileName, mb_strlen($sFilePath));
                    }

                    $sFilePathTMP = $sFilePath;
                    $bFileFound = $io->FileExists($_SERVER['DOCUMENT_ROOT'] . $sFilePath . $sFileName);
                } else {
                    if ($sRealFilePath <> '') {
                        $slash_pos = mb_strrpos($sRealFilePath, "/");
                        $sFilePath = mb_substr($sRealFilePath, 0, $slash_pos + 1);
                    } else {
                        $sFilePath = $APPLICATION->GetCurDir();
                    }

                    $sFilePathTMP = $sFilePath;
                    $sFileName = "sect_" . $arParams["AREA_FILE_SUFFIX_" . $count] . ".php";

                    $bFileFound = $io->FileExists($_SERVER['DOCUMENT_ROOT'] . $sFilePath . $sFileName);

                    if (!$bFileFound && $arParams["AREA_FILE_RECURSIVE_" . $count] == "Y" && $sFilePath != "/") {
                        $finish = false;

                        do {
                            if (str_ends_with($sFilePath, "/")) {
                                $sFilePath = substr($sFilePath, 0, -1);
                            }
                            $slash_pos = mb_strrpos($sFilePath, "/");
                            $sFilePath = mb_substr($sFilePath, 0, $slash_pos + 1);

                            $bFileFound = $io->FileExists($_SERVER['DOCUMENT_ROOT'] . $sFilePath . $sFileName);

                            $finish = $sFilePath == "/";
                        } while (!$finish && !$bFileFound);
                    }
                }
            } else {
                if (substr($arParams["PATH_" . $count], 0, 1) != '/') {

                    if ($sRealFilePath <> '') {
                        $slash_pos = strrpos($sRealFilePath, "/");
                        $sFilePath = substr($sRealFilePath, 0, $slash_pos + 1);
                    } else {
                        $sFilePath = $APPLICATION->GetCurDir();
                    }

                    $arParams["PATH_" . $count] = Rel2Abs($sFilePath, $arParams["PATH_" . $count]);
                }

                $slash_pos = mb_strrpos($arParams['PATH' . $count], "/");
                $sFilePath = mb_substr($arParams['PATH_' . $count], 0, $slash_pos + 1);
                $sFileName = mb_substr($arParams['PATH_' . $count], $slash_pos + 1);

                $bFileFound = $io->FileExists($_SERVER['DOCUMENT_ROOT'] . $sFilePath . $sFileName);

                $sFilePathTMP = $sFilePath;
            }

            $physicalPath = null;
            if ($bFileFound) {
                $physicalPath = $io->GetPhysicalName($_SERVER["DOCUMENT_ROOT"] . $sFilePath . $sFileName);
            }

            $this->files->add(new File(
                fileFound: $bFileFound,
                fileName: $sFileName,
                filePath: $sFilePath,
                filePathTMP: $sFilePathTMP,
                physicalPath: $physicalPath
            ));
        }

        return $arParams;
    }

    /**
     * Выполнение компонента
     * @return void
     */
    public function executeComponent()
    {
        global $APPLICATION;

        $this->arResult["FILES"] = [];

        if ($APPLICATION->GetShowIncludeAreas()) {
            for ($count = 0; $count < $this->arParams["INCLUDE_AREA_COUNT"]; $count++) {
                $this->setFileEditOperation($this->files->offsetGet($count), $count);
            }
        }

        if (!empty($this->files) && $this->files->count() > 0) {
            foreach ($this->files as $file) {
                $this->arResult["FILES"][] = $file->physicalPath;
            }

            $this->includeComponentTemplate();
        }
    }

    /**
     * Установка параметров редактирования файлов для включаемой области
     * @param File $file
     * @param int $count
     * @return void
     */
    protected function setFileEditOperation(File $file, int $count): void
    {
        global $USER, $APPLICATION;

        $locReplaceOptions = array("#COUNT#" => $count + 1);

        $bFileFound = $file->fileFound;
        $sFileName = $file->fileName;
        $sFilePath = $file->filePath;
        $sFilePathTMP = $file->filePathTMP;

        $bPhpFile = (!$USER->CanDoOperation('edit_php') && in_array(GetFileExtension($sFileName), GetScriptFileExt()));

        $bCanEdit = $USER->CanDoFileOperation('fm_edit_existent_file', array(SITE_ID, $sFilePath . $sFileName)) && (!$bPhpFile || $GLOBALS["USER"]->CanDoFileOperation('fm_lpa', array(SITE_ID, $sFilePath . $sFileName)));
        $bCanAdd = $USER->CanDoFileOperation('fm_create_new_file', array(SITE_ID, $sFilePathTMP . $sFileName)) && (!$bPhpFile || $GLOBALS["USER"]->CanDoFileOperation('fm_lpa', array(SITE_ID, $sFilePathTMP . $sFileName)));

        if ($bCanEdit || $bCanAdd) {
            $editor = '&site=' . SITE_ID . '&back_url=' . urlencode($_SERVER['REQUEST_URI']) . '&templateID=' . urlencode(SITE_TEMPLATE_ID);

            if ($bFileFound) {
                if ($bCanEdit) {
                    $arMenu = array();
                    if ($USER->CanDoOperation('edit_php')) {
                        $arMenu[] = array(
                            "ACTION" => 'javascript:' . $APPLICATION->GetPopupLink(
                                    array(
                                        'URL' => "/bitrix/admin/public_file_edit_src.php?lang=" . LANGUAGE_ID . "&template=" . urlencode($this->arParams["EDIT_TEMPLATE_" . $count]) . "&path=" . urlencode($sFilePath . $sFileName) . $editor,
                                        "PARAMS" => array(
                                            'width' => 770,
                                            'height' => 570,
                                            'resize' => true,
                                            "dialog_type" => 'EDITOR',
                                            "min_width" => 700,
                                            "min_height" => 400
                                        )
                                    )
                                ),
                            "ICON" => "panel-edit-php",
                            "TEXT" => Loc::getMessage("main_comp_include_edit_php", $locReplaceOptions),
                            "TITLE" => Loc::getMessage("MAIN_INCLUDE_AREA_EDIT_" . $this->arParams["AREA_FILE_SHOW_" . $count] . "_NOEDITOR", $locReplaceOptions),
                        );
                    }
                    $arIcons = array(
                        array(
                            "URL" => 'javascript:' . $APPLICATION->GetPopupLink(
                                    array(
                                        'URL' => "/bitrix/admin/public_file_edit.php?lang=" . LANGUAGE_ID . "&from=main.include&template=" . urlencode($this->arParams["EDIT_TEMPLATE_" . $count]) . "&path=" . urlencode($sFilePath . $sFileName) . $editor,
                                        "PARAMS" => array(
                                            'width' => 770,
                                            'height' => 570,
                                            'resize' => true
                                        )
                                    )
                                ),
                            "DEFAULT" => $APPLICATION->GetPublicShowMode() != 'configure',
                            "ICON" => "bx-context-toolbar-edit-icon",
                            "TITLE" => Loc::getMessage("main_comp_include_edit", $locReplaceOptions),
                            "ALT" => Loc::getMessage("MAIN_INCLUDE_AREA_EDIT_" . $this->arParams["AREA_FILE_SHOW_" . $count], $locReplaceOptions),
                            "MENU" => $arMenu,
                        ),
                    );
                }

                if ($sFilePath != $sFilePathTMP && $bCanAdd) {
                    $arMenu = array();
                    if ($USER->CanDoOperation('edit_php')) {
                        $arMenu[] = array(
                            "ACTION" => 'javascript:' . $APPLICATION->GetPopupLink(
                                    array(
                                        'URL' => "/bitrix/admin/public_file_edit_src.php?lang=" . LANGUAGE_ID . "&new=Y&path=" . urlencode($sFilePathTMP . $sFileName) . "&new=Y&template=" . urlencode($this->arParams["EDIT_TEMPLATE_" . $count]) . $editor,
                                        "PARAMS" => array(
                                            'width' => 770,
                                            'height' => 570,
                                            'resize' => true,
                                            "dialog_type" => 'EDITOR',
                                            "min_width" => 700,
                                            "min_height" => 400
                                        )
                                    )
                                ),
                            "ICON" => "panel-edit-php",
                            "TEXT" => Loc::getMessage("main_comp_include_add_php", $locReplaceOptions),
                            "TITLE" => Loc::getMessage("MAIN_INCLUDE_AREA_ADD_" . $this->arParams["AREA_FILE_SHOW_" . $count] . "_NOEDITOR", $locReplaceOptions),
                        );
                    }
                    $arIcons[] = array(
                        "URL" => 'javascript:' . $APPLICATION->GetPopupLink(
                                array(
                                    'URL' => "/bitrix/admin/public_file_edit.php?lang=" . LANGUAGE_ID . "&from=main.include&new=Y&path=" . urlencode($sFilePathTMP . $sFileName) . "&new=Y&template=" . urlencode($this->arParams["EDIT_TEMPLATE_" . $count]) . $editor,
                                    "PARAMS" => array(
                                        'width' => 770,
                                        'height' => 570,
                                        'resize' => true
                                    )
                                )
                            ),
                        "DEFAULT" => $APPLICATION->GetPublicShowMode() != 'configure',
                        "ICON" => "bx-context-toolbar-create-icon",
                        "TITLE" => Loc::getMessage("main_comp_include_add", $locReplaceOptions),
                        "ALT" => Loc::getMessage("MAIN_INCLUDE_AREA_ADD_" . $this->arParams["AREA_FILE_SHOW_" . $count], $locReplaceOptions),
                        "MENU" => $arMenu,
                    );
                }
            } elseif ($bCanAdd) {
                $arMenu = array();
                if ($USER->CanDoOperation('edit_php')) {
                    $arMenu[] = array(
                        "ACTION" => 'javascript:' . $APPLICATION->GetPopupLink(
                                array(
                                    'URL' => "/bitrix/admin/public_file_edit_src.php?lang=" . LANGUAGE_ID . "&path=" . urlencode($sFilePathTMP) . "&filename=" . urlencode($sFileName) . "&new=Y&template=" . urlencode($this->arParams["EDIT_TEMPLATE_" . $count]) . $editor,
                                    "PARAMS" => array(
                                        'width' => 770,
                                        'height' => 570,
                                        'resize' => true,
                                        //"dialog_type" => 'EDITOR',
                                        "min_width" => 700,
                                        "min_height" => 400
                                    )
                                )
                            ),
                        "ICON" => "panel-edit-php",
                        "TEXT" => Loc::getMessage("main_comp_include_add1_php", $locReplaceOptions),
                        "TITLE" => Loc::getMessage("MAIN_INCLUDE_AREA_ADD_" . $this->arParams["AREA_FILE_SHOW" . $count] . "_NOEDITOR", $locReplaceOptions),
                    );
                }
                $arIcons = array(
                    array(
                        "URL" => 'javascript:' . $APPLICATION->GetPopupLink(
                                array(
                                    'URL' => "/bitrix/admin/public_file_edit.php?lang=" . LANGUAGE_ID . "&from=main.include&path=" . urlencode($sFilePathTMP . $sFileName) . "&new=Y&template=" . urlencode($this->arParams["EDIT_TEMPLATE_" . $count]) . $editor,
                                    "PARAMS" => array(
                                        'width' => 770,
                                        'height' => 570,
                                        'resize' => true,
                                        "dialog_type" => 'EDITOR',
                                        "min_width" => 700,
                                        "min_height" => 400
                                    )
                                )
                            ),
                        "DEFAULT" => $APPLICATION->GetPublicShowMode() != 'configure',
                        "ICON" => "bx-context-toolbar-create-icon",
                        "TITLE" => Loc::getMessage("main_comp_include_add1", $locReplaceOptions),
                        "ALT" => Loc::getMessage("MAIN_INCLUDE_AREA_ADD_" . $this->arParams["AREA_FILE_SHOW_" . $count], $locReplaceOptions),
                        "MENU" => $arMenu,
                    ),
                );
            }

            if (is_array($arIcons) && !empty($arIcons)) {
                foreach ($arIcons as $arIcon) {
                    $this->addIncludeAreaIcon($arIcon);
                }
            }
        }
    }
}