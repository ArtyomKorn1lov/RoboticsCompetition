<?php

namespace Robot\Core;

/**
 * Константы
 */
class Constants
{
    /** @var string Код ИБ События */
    public const CONTENT_IBLOCK_TYPE = "content";

    /** @var string Код ИБ События */
    public const EVENTS_IBLOCK_CODE = "events";

    /** @var string Код ИБ Мероприятия */
    public const ACTIONS_IBLOCK_CODE = "actions";

    /** @var string Код ИБ Мероприятия */
    public const PARTNERS_IBLOCK_CODE = "partners";

    /** @var string Url страницы регистрации */
    public const REGISTRATION_URL = SITE_DIR."register/";

    /** @var string Формат pdf файла, который выдаёт компонент news.list */
    public const PDF_FORMAT_NEWS_LIST = "application/pdf";

    /** @var string Код ИБ Видеоуроки */
    public const VIDEO_LESSONS_IBLOCK_CODE = "video-lessons";
}