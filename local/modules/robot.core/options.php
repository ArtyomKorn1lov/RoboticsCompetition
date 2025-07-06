<?php
// Настройки модуля в админке
/** @global CMain $APPLICATION */
/** @global string $mid */
/** @global CUser $USER */

use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

use Robot\Core\Constants;

if (!Loader::includeModule('robot.core')) {
    die(Loc::getMessage("ROBOT_CORE_NOT_INCLUDE_MODULE"));
}

Loc::loadMessages(__FILE__);

$currentUrl = $APPLICATION->GetCurPage().'?mid='.urlencode($mid).'&amp;lang='.LANGUAGE_ID;

$request = Context::getCurrent()->getRequest();

$optionList = array(
    Constants::DEFAULT_RECIPIENT_EMAIL_OPTION_CODE
);

if ($request->getRequestMethod() === "POST" && check_bitrix_sessid() && !empty($request->getPost('robot_core_update')) && $request->getPost('robot_core_update') === 'Y') {
    foreach ($optionList as $option) {
        if (!empty($_POST[$option]))
        {
            Option::set('robot.core', $option, $request->getPost($option));
        }
        LocalRedirect($currentUrl);
    }
}

$options = [];
foreach ($optionList as $option) {
    $options[$option] = Option::get('robot.core', $option);
}

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
<?php $tabControl->BeginNextTab(); ?>
    <form id="robot_core_module_options_form" method="post" action="<?= $currentUrl; ?>">
        <tr>
            <td style="width: 40%">
                <?=Loc::getMessage("ROBOT_CORE_DEFAULT_EMAIL_TITLE")?>
            </td>
            <td>
                <label>
                    <input style="width: 40%" type="text" name="<?=Constants::DEFAULT_RECIPIENT_EMAIL_OPTION_CODE?>" value="<?= $options[Constants::DEFAULT_RECIPIENT_EMAIL_OPTION_CODE] ?>" />
                </label>
            </td>
        </tr>
        <?php $tabControl->Buttons(); ?>
        <input type="submit" class="adm-btn-save" name="robot_core_update" value="<?=Loc::getMessage("ROBOT_CORE_OPTIONS_SAVE")?>" />
        <input type="hidden" name="robot_core_update" value="Y">
        <?= bitrix_sessid_post(); ?>
    </form>
<?php $tabControl->BeginNextTab(); ?>
<?php
$tabControl->End();