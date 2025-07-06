<?php
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

// Проверка идентификатора сессии
if (!check_bitrix_sessid()) {
    return;
}

global $APPLICATION;
if ($errorException = $APPLICATION->getException()) {
    // Вывод сообщения об ошибке при установке модуля
    CAdminMessage::showMessage(
        Loc::getMessage('ROBOT_MODULE_FAILED') . ': ' . $errorException->GetString()
    );
}

if (!empty($errorMessage)) {
    CAdminMessage::showMessage($errorMessage);
}

$rsObject = CSite::GetList();

$sites = [
    [
        "id" => null,
        "lid" => null,
        "name" => "Не выбрано",
    ],
];

while ($arSite = $rsObject->fetch()) {
    $sites[] = [
        "id" => $arSite["ID"],
        "lid" => "(".$arSite["LID"].")",
        "name" => $arSite["NAME"],
    ];
}

$tabList = [
    [
        "DIV" => "robot_core_step_1",
        "TAB" => Loc::getMessage("ROBOT_MODULE_TAB_TITLE"),
        "ICON" => "ib_settings",
        "TITLE" => Loc::getMessage("ROBOT_MODULE_SETTINGS_TITLE")
    ]
];

$tabControl = new CAdminTabControl("robot_core_setup_options", $tabList);
$tabControl->Begin();
?>
<?php $tabControl->BeginNextTab(); ?>
<!-- Выводится кнопка для перехода на страницу модулей -->
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <!-- Обязательное получение сессии -->
    <?= bitrix_sessid_post() ?>
    <!-- В форме обязательно должно быть поле lang, с айди языка, чтобы язык не сбросился -->
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <!-- Id модуля для установки -->
    <input type="hidden" name="id" value="robot.core">
    <!-- Обязательно указывать поле install со значением Y, иначе просто перейдем на страницу модулей -->
    <input type="hidden" name="install" value="Y">
    <!-- Определение следующего шага установки модуля -->
    <input type="hidden" name="step" value="2">
    <!-- Параметры необходимые для установки модуля, настраиваются пользователем -->
    <tr class="heading">
        <td colspan="2">
            <?= Loc::getMessage("ROBOT_MODULE_HEAD"); ?>
        </td>
    </tr>
    <tr>
        <td style="width: 40%">
            <?= Loc::getMessage("ROBOT_MODULE_DEFAULT_EMAIL_TITLE") ?>
        </td>
        <td>
            <label>
                <input style="width: 40%" type="text" name="default_email" value="" />
            </label>
        </td>
    </tr>
    <tr class="heading">
        <td colspan="2">
            <?= Loc::getMessage("ROBOT_MODULE_HEAD_SITES"); ?>
        </td>
    </tr>
    <tr>
        <td style="width: 40%">
            <?= Loc::getMessage("ROBOT_MODULE_PRIMARY_SITES") ?>
        </td>
        <td>
            <label>
                <select style="width: 21.3%" name="primary_site_id">
                    <?php foreach ($sites as $site) { ?>
                        <option
                            value="<?= $site["id"] ?>"
                        >
                            <?= $site["lid"] ?> <?= $site["name"] ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
        </td>
    </tr>
    <tr>
        <td style="width: 40%">
            <?= Loc::getMessage("ROBOT_MODULE_SECONDARY_SITES") ?>
        </td>
        <td>
            <label>
                <select style="width: 21.3%" name="secondary_site_id">
                    <?php foreach ($sites as $site) { ?>
                        <option
                            value="<?= $site["id"] ?>"
                        >
                            <?= $site["lid"] ?> <?= $site["name"] ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
        </td>
    </tr>
    <tr class="heading">
        <td colspan="2">
            <?= Loc::getMessage("ROBOT_MODULE_HEAD_ADDITION"); ?>
        </td>
    </tr>
    <tr>
        <td style="width: 40%">
            <?= Loc::getMessage("ROBOT_MODULE_INSTALL_MIGRATIONS"); ?>
        </td>
        <td>
            <label>
                <input style="width: 40%" type="checkbox" name="install_migrations" value="Y" />
            </label>
        </td>
    </tr>
    <?php $tabControl->Buttons(); ?>
    <!-- Кнопка подтверждения выполнения шага -->
    <input type="submit" class="adm-btn-save" value="<?= Loc::getMessage("ROBOT_MODULE_SAVE") ?>">
</form>
<?php $tabControl->BeginNextTab(); ?>
<?php
$tabControl->End();