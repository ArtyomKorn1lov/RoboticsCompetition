<?php
/** @global CMain $APPLICATION */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php";

use Bitrix\Main\Loader;

if (!Loader::includeModule('robot.core')) {
    die("Не подключен главный модуль сайта для проведения соревнований по робототехнике");
}

use Robot\Core\Views\SiteSettings\SiteSettingsView;
use Robot\Core\Entity\SiteSettings\SiteSettingsTable;

// TODO получать настройки сайта отдельно
$arSiteSettings = SiteSettingsView::getSiteSettingsEdit("s1");

if (empty($arSiteSettings)) {
    echo "Не найдены настройки текущего сайта";
    require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php";
    return false;
}

$currentUrl = $APPLICATION->GetCurPage().'?lang='.LANGUAGE_ID;

$optionList = array(
    "EMAIL",
    "PHONE",
    "ADDRESS",
    "ADDRESS_ORGANISATION",
    "CONTACT_PHONES",
    "MAP_COORDINATES",
    "SOCIAL_NETWORKS",
    "SOCIAL_NETWORKS_FOOTER"
);

if ($_SERVER["REQUEST_METHOD"] === "POST" && check_bitrix_sessid() && isset($_POST['robot_core_site_settings_update']) && $_POST['robot_core_site_settings_update'] === 'Y') {
    $arData = [];
    foreach ($optionList as $option) {
        if (!empty($_POST[$option])) {
            $arData[$option] = $_POST[$option];
        }
        $result = SiteSettingsTable::update($arSiteSettings["ID"], $arData);
        if (!$result->isSuccess()) {
            echo $result->getErrorMessage();
            require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php";
            return false;
        }
        LocalRedirect($currentUrl);
    }
}

$options = [];
foreach ($optionList as $option) {
    $options[$option] = $arSiteSettings[$option];
}

$tabList = [
    [
        "DIV" => "robot_core_site_settings_edit_1",
        "TAB" => "Настройки для сайта",
        "ICON" => "ib_settings",
        "TITLE" => "Настройки для сайта для проведения соревнований по робототехнике"
    ]
];

$tabControl = new CAdminTabControl("robot_core_site_settings_options", $tabList);
$tabControl->Begin();
?>
    <form id="robot_core_site_settings_form" method="post" action="<?= $currentUrl; ?>">
        <?php $tabControl->BeginNextTab(); ?>
        <tr>
            <td style="width: 40%">
                E-mail организации:
            </td>
            <td>
                <label>
                    <input style="width: 40%" type="text" name="EMAIL" value="<?= $options["EMAIL"] ?>" />
                </label>
            </td>
        </tr>
        <tr>
            <td style="width: 40%">
                Номер телефона организации:
            </td>
            <td>
                <label>
                    <input style="width: 40%" type="text" name="PHONE" value="<?= $options["PHONE"] ?>" />
                </label>
            </td>
        </tr>
        <tr>
            <td style="width: 40%">
                Адрес организации:
            </td>
            <td>
                <label>
                    <input style="width: 40%" type="text" name="ADDRESS" value="<?= $options["ADDRESS"] ?>" />
                </label>
            </td>
        </tr>
        <?php $tabControl->Buttons(); ?>
        <input type="submit" class="adm-btn-save" name="robot_core_site_settings_update" value="Сохранить" />
        <input type="hidden" name="robot_core_site_settings_update" value="Y">
        <?= bitrix_sessid_post(); ?>
    </form>
<?php
$tabControl->End();

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php";
