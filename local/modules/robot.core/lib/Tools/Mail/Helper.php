<?php

namespace Robot\Core\Tools\Mail;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\SystemException;

Loc::loadMessages(__FILE__);

class Helper implements IHelper
{
    /** @var string Почтовое событие */
    private string $mailEvent;

    /** @var string Id сайта */
    private string $lid;


    /**
     * @param string $mailEvent
     * @param string $lid
     */
    public function __construct(string $mailEvent, string $lid = "s1")
    {
        $this->mailEvent = $mailEvent;
        $this->lid = $lid;
    }

    /**
     * @param array $arFields
     * @return void
     * @throws SystemException
     */
    public function sendMail(array $arFields): void
    {
        $result = Event::send([
            "EVENT_NAME" => $this->mailEvent,
            "LID" => $this->lid,
            "C_FIELDS" => $arFields
        ]);
        if (!$result->isSuccess()) {
            throw new SystemException(Loc::getMessage("ROBOT_CORE_ERROR_MAIL_SEND"));
        }
    }
}