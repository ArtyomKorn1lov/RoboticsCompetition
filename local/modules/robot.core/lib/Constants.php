<?php

namespace Robot\Core;

/**
 * Константы
 */
class Constants
{
    /** @var string Код ИБ События */
    public const CONTENT_IBLOCK_TYPE = "robot_content";

    /** @var string Код ИБ Обратная связь */
    public const FEEDBACK_IBLOCK_TYPE = "robot_feedback";

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

    /** @var string Код ИБ Архив */
    public const ARCHIVE_IBLOCK_CODE = "archive";

    /** @var string Код ИБ Программа */
    public const PROGRAM_IBLOCK_CODE = "program";

    /** @var string Код ИБ Программа */
    public const DOCUMENT_IBLOCK_CODE = "documents";

    /** @var string Код ИБ Заявки с формы регистрации */
    public const REGISTRATION_REQUEST_IBLOCK_CODE = "registration-request";

    /** @var string Код свойства сущности справочника ID */
    public const UF_FIELD_CODE_ID = "ID";

    /** @var string Код свойства сущности справочника UF_CODE */
    public const UF_FIELD_CODE_CODE = "UF_CODE";

    /** @var string Код свойства сущности справочника UF_FIELD_CODE_VALUE */
    public const UF_FIELD_CODE_VALUE = "UF_VALUE";

    /** @var string Код свойства сущности справочника UF_SORT */
    public const UF_FIELD_CODE_SORT = "UF_SORT";

    /** @var string Код поля форм autocomplete */
    public const CODE_FIELD_AUTOCOMPLETE = "autocomplete";
}