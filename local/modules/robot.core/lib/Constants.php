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

    /** @var string Код ИБ Организаторы */
    public const PARTNERS_IBLOCK_CODE = "partners";

    /** @var string Код ИБ Организаторы - англ. версия */
    public const PARTNERS_EN_IBLOCK_CODE = "partners_en";

    /** @var string Url страницы регистрации */
    public const REGISTRATION_URL = SITE_DIR."register/";

    /** @var string Код ИБ Видеоуроки */
    public const VIDEO_LESSONS_IBLOCK_CODE = "video-lessons";

    /** @var string Код ИБ Видеоуроки - англ. версия */
    public const VIDEO_LESSONS_EN_IBLOCK_CODE = "video-lessons_en";

    /** @var string Код ИБ Архив */
    public const ARCHIVE_IBLOCK_CODE = "archive";

    /** @var string Код ИБ Программа */
    public const PROGRAM_IBLOCK_CODE = "program";

    /** @var string Код ИБ Документы */
    public const DOCUMENT_IBLOCK_CODE = "documents";

    /** @var string Код ИБ Документы - англ. версия */
    public const DOCUMENT_IBLOCK_CODE_EN = "documents_en";

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

    /** @var int Увеличение карты при инициализации */
    public const CONTACT_MAP_ZOOM = 17;

    /** @var string Иконка геообъекта на карте */
    public const CONTACT_MAP_ICON_PATH = '/local/templates/robot/app/img/map_icon.svg';

    /** @var int[] Размеры геообъекта на карте */
    public const CONTACT_MAP_ICON_SIZE = [35, 53];

    /** @var string Русский язык для сайта */
    public const LANG_RUSSIA_CODE = "ru";

    /** @var string Английский язык для сайта */
    public const LANG_ENGLISH_CODE = "en";
}