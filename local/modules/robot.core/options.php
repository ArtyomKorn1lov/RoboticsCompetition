<?php
// Настройки модуля в админке
/** @global CMain $APPLICATION */
/** @global string $mid */
/** @global CUser $USER */

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

if(!$USER->IsAdmin()) {
    return;
}

if (!Loader::includeModule('robot.core')) {
    return;
}

Loc::loadMessages(__FILE__);

$currentUrl = $APPLICATION->GetCurPage().'?mid='.urlencode($mid).'&amp;lang='.LANGUAGE_ID;

// TODO при необходимости доделать настройки модуля, внутри данного файла

/*$optionList = array(
    'robot_core_api_key_map'
);

if ($_SERVER["REQUEST_METHOD"] === "POST" && check_bitrix_sessid() && isset($_POST['robot_core_update']) && $_POST['robot_core_update'] === 'Y') {
    foreach ($optionList as $option) {
        if (!empty($_POST[$option]))
        {
            Option::set('robot.core', $option, $_POST[$option], '');
        }
        LocalRedirect($currentUrl);
    }
}

$options = [];
foreach ($optionList as $option) {
    $options[$option] = (string)Option::get('robot.core', $option);
}*/

$tabList = [
    [
        "DIV" => "robot_core_edit_1",
        "TAB" => Loc::getMessage("ROBOT_MODULE_TAB_TITLE"),
        "ICON" => "ib_settings",
        "TITLE" => Loc::getMessage("ROBOT_MODULE_SETTINGS_TITLE")
    ]
];

$tabControl = new CAdminTabControl("robot_core_module_options", $tabList);
$tabControl->Begin();
?>
    <!--<form id="robot_core_module_options_form" method="post" action="<?php /*= $currentUrl; */?>">
        <?php /*$tabControl->BeginNextTab(); */?>
        <tr>
            <td style="width: 40%">
                Ключ API Яндекс карт:
            </td>
            <td>
                <label>
                    <input style="width: 40%" type="text" name="robot_core_api_key_map" value="<?php /*= $options["robot_core_api_key_map"] */?>" />
                </label>
            </td>
        </tr>
        <?php /*$tabControl->Buttons(); */?>
        <input type="submit" class="adm-btn-save" name="robot_core_update" value="Сохранить" />
        <input type="hidden" name="robot_core_update" value="Y">
        <?php /*= bitrix_sessid_post(); */?>
    </form>-->
    <?php $tabControl->BeginNextTab(); ?>
    <p>
        Пока ничего нет, настройки могут появиться в последующих версиях модуля
    </p>
<?php
$tabControl->End();