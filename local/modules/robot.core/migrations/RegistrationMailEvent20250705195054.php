<?php

namespace Sprint\Migration;


class RegistrationMailEvent20250705195054 extends Version
{
    protected $author = "admin";

    protected $description = "Тип почтового события и почтовый шаблон - регистрация на событие";

    protected $moduleVersion = "5.0.2";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Event()->saveEventType('ROBOT_REGISTRATION', array(
            'LID' => 'ru',
            'EVENT_TYPE' => 'email',
            'NAME' => 'Отправка письма с формы регистрации на событие',
            'DESCRIPTION' => '',
            'SORT' => '100',
        ));
        $helper->Event()->saveEventType('ROBOT_REGISTRATION', array(
            'LID' => 'en',
            'EVENT_TYPE' => 'email',
            'NAME' => 'Отправка письма с формы регистрации на событие',
            'DESCRIPTION' => '',
            'SORT' => '100',
        ));
        $helper->Event()->saveEventMessage('ROBOT_REGISTRATION', array(
            'LID' =>
                array(
                    0 => 's1',
                    1 => 's2',
                ),
            'ACTIVE' => 'Y',
            'EMAIL_FROM' => '#EMAIL#',
            'EMAIL_TO' => '#DEFAULT_RECIPIENT_EMAIL#',
            'SUBJECT' => '#SITE_NAME#: Зарегистрировался новый пользователь',
            'MESSAGE' => 'Информационное сообщение сайта "#SITE_NAME#"
------------------------------------------

Зарегистрировался новый пользователь на событие "#EVENT_NAME#".

Информация об участнике:

ФИО участника: #NAME#
Дата рождения: #BIRTHDAY#
Страна: #COUNTRY#
Курс: #COURSE#
Шифр и наименование направления подготовки: #CODE_AND_AREA_TRAINING#
Телефон: #PHONE#
E-mail: #EMAIL#

Дополнительный комментарий:
#PREVIEW_TEXT#

Для просмотра детальной информации об участнике перейдите по ссылке:
https://#SERVER_NAME#/#EDIT_URL#',
            'BODY_TYPE' => 'text',
            'BCC' => '',
            'REPLY_TO' => '',
            'CC' => '',
            'IN_REPLY_TO' => '',
            'PRIORITY' => '',
            'FIELD1_NAME' => '',
            'FIELD1_VALUE' => '',
            'FIELD2_NAME' => '',
            'FIELD2_VALUE' => '',
            'SITE_TEMPLATE_ID' => '',
            'ADDITIONAL_FIELD' =>
                array(),
            'LANGUAGE_ID' => 'ru',
            'EVENT_TYPE' => '[ ROBOT_REGISTRATION ] Отправка письма с формы регистрации на событие',
        ));
    }
}
