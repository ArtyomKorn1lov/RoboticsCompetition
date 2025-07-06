<?php

namespace Robot\Core\Middleware;

use Bitrix\Main\Engine\ActionFilter\Base;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Localization\Loc;

use Robot\Core\Constants;

/**
 * Middleware - установка языка в зависимости от заголовков запроса
 */
class Language extends Base
{
    /** @var string Заголовок запроса lang, содержащий информацию о языке */
    protected const HEADER_LANG_CODE = 'lang';

    /**
     * @param Event $event
     * @return EventResult
     */
    public function onBeforeAction(Event $event): EventResult
    {
        $request = $this->action->getController()->getRequest();
        $lang = $request->getHeader(self::HEADER_LANG_CODE);
        if (!empty($lang) && $lang === Constants::LANG_ENGLISH_CODE) {
            Loc::setCurrentLang(Constants::LANG_ENGLISH_CODE);
        } else {
            Loc::setCurrentLang(Constants::LANG_RUSSIA_CODE);
        }
        return new EventResult(EventResult::SUCCESS);
    }
}