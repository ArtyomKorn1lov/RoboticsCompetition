<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arType = array("page" => Loc::getMessage("MAIN_INCLUDE_PAGE"), "sect" => Loc::getMessage("MAIN_INCLUDE_SECT"));
if ($GLOBALS['USER']->CanDoOperation('edit_php'))
{
    $arType["file"] = Loc::getMessage("MAIN_INCLUDE_FILE");
}

$site_template = false;
$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
if($site !== false)
{
    $rsSiteTemplates = CSite::GetTemplateList($site);
    while($arSiteTemplate = $rsSiteTemplates->Fetch())
    {
        if($arSiteTemplate["CONDITION"] == '')
        {
            $site_template = $arSiteTemplate["TEMPLATE"];
            break;
        }
    }
}
if (CModule::IncludeModule('fileman'))
{
    $arTemplates = CFileman::GetFileTemplates(LANGUAGE_ID, array($site_template));
    $arTemplatesList = array();
    foreach ($arTemplates as $key => $arTemplate)
    {
        $arTemplateList[$arTemplate["file"]] = "[".$arTemplate["file"]."] ".$arTemplate["name"];
    }
}
else
{
    $arTemplatesList = array("page_inc.php" => "[page_inc.php]", "sect_inc.php" => "[sect_inc.php]");
}

$arComponentParameters = array(
    "GROUPS" => array(
        "PARAMS" => array(
            "NAME" => Loc::getMessage("MAIN_INCLUDE_PARAMS"),
        ),
    ),

    "PARAMETERS" => array(
        "INCLUDE_AREA_COUNT" => array(
            "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_COUNT"),
            "DEFAULT" => "1",
            "TYPE" => "STRING",
            "PARENT" => "PARAMS",
            "REFRESH" => "Y",
        ),
    ),
);

$areaCount = !empty($arCurrentValues["INCLUDE_AREA_COUNT"]) ? (int)$arCurrentValues["INCLUDE_AREA_COUNT"] : 1;

for ($count = 0; $count < $areaCount; $count++) {

    $arComponentParameters["GROUPS"]["ITEM_AREA_" . $count] = [
        "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_TITLE", ["#COUNT#" => $count + 1]),
    ];

    $arComponentParameters["PARAMETERS"]["AREA_FILE_SHOW_" . $count] = [
        "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_FILE_SHOW"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "VALUES" => $arType,
        "ADDITIONAL_VALUES" => "N",
        "DEFAULT" => "page",
        "PARENT" => "ITEM_AREA_" . $count,
        "REFRESH" => "Y",
    ];

    if ($GLOBALS['USER']->CanDoOperation('edit_php') && $arCurrentValues["AREA_FILE_SHOW_" . $count] == "file") {

        $arComponentParameters["PARAMETERS"]["PATH_" . $count] = [
            "NAME" => Loc::getMessage("MAIN_INCLUDE_PATH"),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "ADDITIONAL_VALUES" => "N",
            "PARENT" => "ITEM_AREA_" . $count,
        ];

    } else {

        $arComponentParameters["PARAMETERS"]["AREA_FILE_SUFFIX_" . $count] = [
            "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_FILE_SUFFIX"),
            "TYPE" => "STRING",
            "DEFAULT" => "inc",
            "PARENT" => "ITEM_AREA_" . $count,
        ];

        if ($arCurrentValues["AREA_FILE_SHOW"] == "sect") {
            $arComponentParameters["PARAMETERS"]["AREA_FILE_RECURSIVE_" . $count] = [
                "NAME" => Loc::getMessage("MAIN_INCLUDE_AREA_FILE_RECURSIVE"),
                "TYPE" => "CHECKBOX",
                "ADDITIONAL_VALUES" => "N",
                "DEFAULT" => "Y",
                "PARENT" => "ITEM_AREA_" . $count,
            ];
        }

    }

    $arComponentParameters["PARAMETERS"]["EDIT_TEMPLATE_" . $count] = [
        "NAME" => Loc::getMessage("MAIN_INCLUDE_EDIT_TEMPLATE"),
        "TYPE" => "LIST",
        "VALUES" => $arTemplateList,
        "DEFAULT" => "",
        "ADDITIONAL_VALUES" => "Y",
        "PARENT" => "ITEM_AREA_" . $count,
    ];

}
