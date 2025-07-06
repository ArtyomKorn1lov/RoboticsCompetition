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
} else {
    // Вывод уведомления при успешной установке модуля
    CAdminMessage::showNote(
        Loc::getMessage('ROBOT_MODULE_SUCCESS')
    );
}

?>
<!-- Вывод кнопки для перехода на страницу модулей -->
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <!-- В форме обязательно должно быть поле lang, с id языка, чтобы язык не сбросился -->
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <!-- Кнопка вернуться к списку модулей -->
    <input type="submit" name="" value="<?= Loc::getMessage("ROBOT_MODULE_RETURN") ?>">
</form>