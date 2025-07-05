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