<?php
/** @global CMain $APPLICATION */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php";

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;

if (!Loader::includeModule('robot.core')) {
    die("Не подключен главный модуль сайта для проведения соревнований по робототехнике");
}

use Robot\Core\Views\SiteSettings\SiteSettingsView;
use Robot\Core\Enums\SocialIcons;

// TODO получать настройки сайта отдельно
$arSiteSettings = SiteSettingsView::getSiteSettingsEdit("s1");

if (empty($arSiteSettings)) {
    ShowError("Не найдены настройки текущего сайта");
    require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php";
    return false;
}

$currentUrl = $APPLICATION->GetCurPage().'?lang='.LANGUAGE_ID;

$optionList = array(
    "NAME",
    "EMAIL",
    "PHONE",
    "ADDRESS",
    "LOGO",
    "LOGO_FOOTER",
    "ADDRESS_ORGANISATION",
    "CONTACT_PHONES",
    "MAP_COORDINATES",
    "SOCIAL_NETWORKS",
    "SOCIAL_NETWORKS_FOOTER"
);

if ($_SERVER["REQUEST_METHOD"] === "POST" && check_bitrix_sessid() && isset($_POST['robot_core_site_settings_update']) && $_POST['robot_core_site_settings_update'] === 'Y') {
    $arData = [];
    foreach ($optionList as $option) {
        foreach ($_POST as $key => $postItem) {
            if ($key === $option) {
                $arData[$option] = $postItem;
            }
            else if (str_contains($key, $option)) {
                $arData[$key] = htmlspecialchars($postItem);
            }
        }
    }
    foreach ($optionList as $option) {
        foreach ($_FILES as $key => $fileItem) {
            if ($key === $option) {
                $arData[$option] = $fileItem;
            }
        }
    }
    $result = SiteSettingsView::saveSiteSettings($arSiteSettings["ID"], $arData);
    if (gettype($result) === "string") {
        ShowError($result);
    } else {
        LocalRedirect($currentUrl);
    }
}

$socialIcons = SocialIcons::getSelectDefaultList();
$socialIconsFooter = SocialIcons::getSelectFooterList();

$options = [];
foreach ($optionList as $option) {
    $options[$option] = $arSiteSettings[$option];
}

$tabList = [
    [
        "DIV" => "robot_core_site_settings_edit_1",
        "TAB" => "Настройки для сайта проведения соревнований по робототехнике",
        "ICON" => "ib_settings",
        "TITLE" => "Настройки для сайта проведения соревнований по робототехнике"
    ]
];

$tabControl = new CAdminTabControl("robot_core_site_settings_options", $tabList);
$tabControl->Begin();
?>
    <form
        id="robot_core_site_settings_form"
        enctype="multipart/form-data"
        method="post"
        action="<?= $currentUrl; ?>"
    >
        <?php $tabControl->BeginNextTab(); ?>
        <tr class="heading">
            <td colspan="2">
                Общая информация об организации:
            </td>
        </tr>
        <?php /** Название организации */ ?>
        <tr>
            <td style="width: 40%">
                Название организации:
            </td>
            <td>
                <label>
                    <input style="width: 40%" type="text" name="NAME" value="<?= $options["NAME"] ?>" />
                </label>
            </td>
        </tr>
        <?php /** ! Название организации */ ?>
        <?php /** Email организации */ ?>
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
        <?php /** ! Email организации */ ?>
        <?php /** Номер телефона организации */ ?>
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
        <?php /** ! Номер телефона организации */ ?>
        <?php /** Адрес организации */ ?>
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
        <?php /** ! Адрес организации */ ?>
        <?php /** Загрузить иконку для шапки и футера сайта */ ?>
        <tr class="heading">
            <td colspan="2">
                Файлы организации (при загрузке файла, произойдёт замена выбранного ресурса):
            </td>
        </tr>
        <tr>
            <td style="width: 40%">
                Логотип для шапки сайта:
            </td>
            <td>
                <?php if (!empty($options["LOGO"])) { ?>
                    <div style="aspect-ratio: 1/1; width: 100%; max-width: 100px;">
                        <img style="width: 100%; height: 100%; object-fit: cover;" src="<?=$options["LOGO"]?>" alt="Логотип в шапке сайта">
                    </div>
                <?php } else { ?>
                    Файл ещё не был загружен в систему
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="width: 40%"></td>
            <td>
                <label>
                    <input type="file" name="LOGO" accept="image/jpeg, image/png, image/bmp, image/svg+xml" />
                </label>
            </td>
        </tr>
        <tr>
            <td style="width: 40%">
                Логотип для подвала сайта:
            </td>
            <td>
                <?php if (!empty($options["LOGO_FOOTER"])) { ?>
                    <div style="aspect-ratio: 1/1; width: 100%; max-width: 100px;">
                        <img style="width: 100%; height: 100%; object-fit: cover;" src="<?=$options["LOGO_FOOTER"]?>" alt="Логотип в шапке сайта">
                    </div>
                <?php } else { ?>
                    Файл ещё не был загружен в систему
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="width: 40%"></td>
            <td>
                <label>
                    <input type="file" name="LOGO_FOOTER" accept="image/jpeg, image/png, image/bmp, image/svg+xml" />
                </label>
            </td>
        </tr>
        <?php /** Загрузить иконку для шапки и футера сайта */ ?>
        <?php /** Контактные адреса организации */ ?>
        <tr class="heading">
            <td colspan="2">
                Контактные адреса:
            </td>
        </tr>
        <tr>
            <td style="width: 40%; padding-right: 127px;">
                Название
            </td>
            <td>
                Описание
            </td>
        </tr>
        <?php
            $indexAddressOrganisation = 1;
            foreach ($options["ADDRESS_ORGANISATION"] as $key => $item) {
        ?>
        <tr>
            <td style="width: 40%">
                <label>
                    <input style="width: 20%" type="text" name="ADDRESS_ORGANISATION_LABEL_<?= $indexAddressOrganisation ?>" value="<?= $key ?>" />
                </label>
            </td>
            <td>
                <label>
                    <input style="width: 60%" type="text" name="ADDRESS_ORGANISATION_VALUE_<?= $indexAddressOrganisation ?>" value="<?= $item ?>" />
                </label>
            </td>
        </tr>
        <?php
                $indexAddressOrganisation++;
            }
        ?>
        <tr>
            <td style="width: 40%">
                <label>
                    <input style="width: 20%" type="text" name="ADDRESS_ORGANISATION_LABEL_<?= $indexAddressOrganisation ?>" value="" />
                </label>
            </td>
            <td>
                <label>
                    <input style="width: 60%" type="text" name="ADDRESS_ORGANISATION_VALUE_<?= $indexAddressOrganisation ?>" value="" />
                </label>
            </td>
        </tr>
        <tr class="address_organisation_add">
            <td style="width: 40%"></td>
            <td>
                <input type="button" class="address_organisation_add_input" value="Добавить" />
            </td>
        </tr>
        <?php /** ! Контактные адреса организации */ ?>
        <?php /** Контактные номера телефонов */ ?>
        <tr class="heading">
            <td colspan="2">
                Контактные номера телефонов:
            </td>
        </tr>
        <tr>
            <td style="width: 40%; padding-right: 127px;">
                Название
            </td>
            <td>
                Описание
            </td>
        </tr>
        <?php
        $indexContactPhones = 1;
        foreach ($options["CONTACT_PHONES"] as $key => $item) {
            ?>
            <tr>
                <td style="width: 40%">
                    <label>
                        <input style="width: 20%" type="text" name="CONTACT_PHONES_LABEL_<?= $indexContactPhones ?>" value="<?= $key ?>" />
                    </label>
                </td>
                <td>
                    <label>
                        <input style="width: 60%" type="text" name="CONTACT_PHONES_VALUE_<?= $indexContactPhones ?>" value="<?= $item ?>" />
                    </label>
                </td>
            </tr>
            <?php
            $indexContactPhones++;
        }
        ?>
        <tr>
            <td style="width: 40%">
                <label>
                    <input style="width: 20%" type="text" name="CONTACT_PHONES_LABEL_<?= $indexContactPhones ?>" value="" />
                </label>
            </td>
            <td>
                <label>
                    <input style="width: 60%" type="text" name="CONTACT_PHONES_VALUE_<?= $indexContactPhones ?>" value="" />
                </label>
            </td>
        </tr>
        <tr class="contact_phones_add">
            <td style="width: 40%"></td>
            <td>
                <input type="button" class="contact_phones_add_input" value="Добавить" />
            </td>
        </tr>
        <?php /** ! Контактные номера телефонов */ ?>
        <?php /** Социальные сети */ ?>
        <tr class="heading">
            <td colspan="2">
                Социальные сети:
            </td>
        </tr>
        <tr>
            <td style="width: 40%; padding-right: 120px;">
                Код иконки
            </td>
            <td>
                Ссылка на ресурс
            </td>
        </tr>
        <?php
        $indexSocialNetworks = 1;
        foreach ($options["SOCIAL_NETWORKS"] as $key => $item) {
            ?>
            <tr>
                <td style="width: 40%">
                    <label>
                        <select style="width: 21.3%" name="SOCIAL_NETWORKS_LABEL_<?= $indexSocialNetworks ?>">
                            <?php foreach ($socialIcons as $icon) { ?>
                                <option
                                    value="<?= $icon["value"] ?>"
                                    <?php if ($key === $icon["value"]) { ?>selected<?php } ?>
                                >
                                    <?= $icon["label"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </label>
                </td>
                <td>
                    <label>
                        <input style="width: 60%" type="text" name="SOCIAL_NETWORKS_VALUE_<?= $indexSocialNetworks ?>" value="<?= $item ?>" />
                    </label>
                </td>
            </tr>
            <?php
            $indexSocialNetworks++;
        }
        ?>
        <tr>
            <td style="width: 40%">
                <label>
                    <select style="width: 21.3%" name="SOCIAL_NETWORKS_LABEL_<?= $indexSocialNetworks ?>">
                        <?php foreach ($socialIcons as $icon) { ?>
                            <option
                                value="<?= $icon["value"] ?>"
                                <?php if (empty($icon["value"])) { ?>selected<?php } ?>
                            >
                                <?= $icon["label"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>
            </td>
            <td>
                <label>
                    <input style="width: 60%" type="text" name="SOCIAL_NETWORKS_VALUE_<?= $indexSocialNetworks ?>" value="" />
                </label>
            </td>
        </tr>
        <tr class="social_networks_add">
            <td style="width: 40%"></td>
            <td>
                <input type="button" class="social_networks_add_input" value="Добавить" />
            </td>
        </tr>
        <?php /** ! Социальные сети */ ?>
        <?php /** Социальные сети в футере */ ?>
        <tr class="heading">
            <td colspan="2">
                Социальные сети в подвале сайта:
            </td>
        </tr>
        <tr>
            <td style="width: 40%; padding-right: 120px;">
                Код иконки
            </td>
            <td>
                Ссылка на ресурс
            </td>
        </tr>
        <?php
        $indexSocialNetworksFooter = 1;
        foreach ($options["SOCIAL_NETWORKS_FOOTER"] as $key => $item) {
            ?>
            <tr>
                <td style="width: 40%">
                    <label>
                        <select style="width: 21.3%" name="SOCIAL_NETWORKS_FOOTER_LABEL_<?= $indexSocialNetworksFooter ?>">
                            <?php foreach ($socialIconsFooter as $icon) { ?>
                                <option
                                    value="<?= $icon["value"] ?>"
                                    <?php if ($key === $icon["value"]) { ?>selected<?php } ?>
                                >
                                    <?= $icon["label"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </label>
                </td>
                <td>
                    <label>
                        <input style="width: 60%" type="text" name="SOCIAL_NETWORKS_FOOTER_VALUE_<?= $indexSocialNetworksFooter ?>" value="<?= $item ?>" />
                    </label>
                </td>
            </tr>
            <?php
            $indexSocialNetworksFooter++;
        }
        ?>
        <tr>
            <td style="width: 40%">
                <label>
                    <select style="width: 21.3%" name="SOCIAL_NETWORKS_FOOTER_LABEL_<?= $indexSocialNetworksFooter ?>">
                        <?php foreach ($socialIconsFooter as $icon) { ?>
                            <option
                                value="<?= $icon["value"] ?>"
                                <?php if (empty($icon["value"])) { ?>selected<?php } ?>
                            >
                                <?= $icon["label"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>
            </td>
            <td>
                <label>
                    <input style="width: 60%" type="text" name="SOCIAL_NETWORKS_FOOTER_VALUE_<?= $indexSocialNetworksFooter ?>" value="" />
                </label>
            </td>
        </tr>
        <tr class="social_networks_footer_add">
            <td style="width: 40%"></td>
            <td>
                <input type="button" class="social_networks_footer_add_input" value="Добавить" />
            </td>
        </tr>
        <?php /** ! Социальные сети в футере */ ?>
        <?php /** Координаты точки на карте */ ?>
        <tr class="heading">
            <td colspan="2">
                Координаты точки на карте:
            </td>
        </tr>
        <?php
        $indexMapCoordinates = 1;
        foreach ($options["MAP_COORDINATES"] as $item) {
            ?>
            <tr>
                <td style="width: 40%"></td>
                <td>
                    <label>
                        <input style="width: 20%" type="text" name="MAP_COORDINATES_VALUE_<?= $indexMapCoordinates ?>" value="<?= $item ?>" />
                    </label>
                </td>
            </tr>
            <?php
            $indexMapCoordinates++;
        }
        ?>
        <?php /** ! Координаты точки на яндекс карте */ ?>
        <?php $tabControl->Buttons(); ?>
        <input type="submit" class="adm-btn-save" name="robot_core_site_settings_update" value="Сохранить" />
        <input type="hidden" name="robot_core_site_settings_update" value="Y">
        <?= bitrix_sessid_post(); ?>
    </form>
    <script>
        BX.ready(() => {
            function createSelectKeyField(fieldCode, index, options) {
                let string = `<td style="width: 40%" class="adm-detail-content-cell-l"><label>`;
                string = string + `<select style="width: 21.3%" name="${fieldCode}_LABEL_${index}">`;

                options.forEach((item) => {
                    string = string + (!!item.value ? `<option value="${item.value}">${item.label}</option>` : `<option value="${item.value}" selected>${item.label}</option>`);
                });

                string = string + `</select></label></td><td class="adm-detail-content-cell-r"><label><input style="width: 60%" type="text" name="${fieldCode}_VALUE_${index}" value="" /></label></td>`;

                return string;
            }

            function dynamicFieldAddHandler(
                fieldCode,
                btnWrapperClass,
                btnClass,
                formWrapper,
                lastIndex,
                options = null
            ) {
                const addBtnWrap = document.querySelector(btnWrapperClass);
                const addBtn = document.querySelector(btnClass);
                const wrapper = document.querySelector(formWrapper)?.children[0];

                if (!wrapper) {
                    return;
                }

                let index = lastIndex;

                addBtn.addEventListener('click', () => {
                    index++;
                    let string = "";
                    if (options && options.length > 0) {
                        string = createSelectKeyField(fieldCode, index, options);
                    } else {
                        string = `<td style="width: 40%" class="adm-detail-content-cell-l"><label><input style="width: 20%" type="text" name="${fieldCode}_LABEL_${index}" value="" /></label></td><td class="adm-detail-content-cell-r"><label><input style="width: 60%" type="text" name="${fieldCode}_VALUE_${index}" value="" /></label></td>`;
                    }
                    let element = document.createElement('tr');
                    element.innerHTML = string;
                    wrapper.insertBefore(element, addBtnWrap);
                });
            }

            dynamicFieldAddHandler(
                'ADDRESS_ORGANISATION',
                '.address_organisation_add',
                '.address_organisation_add_input',
                '#robot_core_site_settings_edit_1_edit_table',
                <?= $indexAddressOrganisation ?>
            );

            dynamicFieldAddHandler(
                'CONTACT_PHONES',
                '.contact_phones_add',
                '.contact_phones_add_input',
                '#robot_core_site_settings_edit_1_edit_table',
                <?= $indexContactPhones ?>
            );

            dynamicFieldAddHandler(
                'SOCIAL_NETWORKS',
                '.social_networks_add',
                '.social_networks_add_input',
                '#robot_core_site_settings_edit_1_edit_table',
                <?= $indexSocialNetworks ?>,
                <?= Json::encode($socialIcons) ?>
            );

            dynamicFieldAddHandler(
                'SOCIAL_NETWORKS_FOOTER',
                '.social_networks_footer_add',
                '.social_networks_footer_add_input',
                '#robot_core_site_settings_edit_1_edit_table',
                <?= $indexSocialNetworksFooter ?>,
                <?= Json::encode($socialIconsFooter) ?>
            );
        });
    </script>
<?php
$tabControl->End();

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php";
