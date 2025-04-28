<?php

namespace Robot\Core\Entity\SiteSettings;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use CFile;

use Robot\Core\Tools\Modules\Manager;

final class SiteSettingsUpdate
{
    /** @var int Id обновляемого элемента */
    private int $id;

    /** @var array Поля настроек сайта */
    private array $siteSettingsFields;

    /** @var string Код поля контактные адреса организации */
    private const FIELD_ADDRESS_ORGANISATION_CODE = "ADDRESS_ORGANISATION";

    /** @var string Код поля контактные номера телефонов */
    private const FIELD_CONTACT_PHONES_CODE = "CONTACT_PHONES";

    /** @var string Код поля координаты точки на карте */
    private const FIELD_MAP_COORDINATES_CODE = "MAP_COORDINATES";

    /** @var string Код поля email организации */
    private const FIELD_EMAIL_CODE = "EMAIL";

    /** @var string Код поля номер телефона организации */
    private const FIELD_PHONE_CODE = "PHONE";

    /** @var string Код поля адрес организации */
    private const FIELD_ADDRESS_CODE = "ADDRESS";

    /** @var string Код поля соц. сети в футере */
    private const FIELD_SOCIAL_NETWORKS_FOOTER_CODE = "SOCIAL_NETWORKS_FOOTER";

    /** @var string Код поля контактные соц. сети */
    private const FIELD_SOCIAL_NETWORKS_CODE = "SOCIAL_NETWORKS";

    /** @var string Код поля логотип сайта */
    private const FIELD_LOGO_CODE = "LOGO";

    /** @var string Код поля логотип сайта в футере */
    private const FIELD_LOGO_FOOTER_CODE = "LOGO_FOOTER";

    /** @var string Код идентификатора для определения поля как значения */
    private const VALUE_STR_CONTAIN = "VALUE";

    /** @var string Код идентификатора для определения поля как label */
    private const LABEL_STR_CONTAIN = "LABEL";

    /**
     * @param int $id
     * @param array $arSiteSettingsFields
     * @throws ArgumentException
     * @throws ObjectException
     * @throws SystemException
     */
    public function __construct(
        int $id,
        array $arSiteSettingsFields,
    )
    {
        $this->validate($id, $arSiteSettingsFields);

        $this->id = $id;
        $this->siteSettingsFields = $this->compareFieldsArray($arSiteSettingsFields);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getSiteSettingsFields(): array
    {
        return $this->siteSettingsFields;
    }

    /**
     * @param int $id
     * @param array $arSiteSettingsFields
     * @return void
     * @throws ArgumentException
     * @throws ObjectException
     */
    protected function validate(int $id, array $arSiteSettingsFields): void
    {
        if (empty($id)) {
            throw new ArgumentException("Id обновляемого элемента не может быть <= 0");
        }

        if (empty($arSiteSettingsFields)) {
            throw new ObjectException("Значения формы не заполнены");
        }

        if (empty($arSiteSettingsFields[self::FIELD_EMAIL_CODE])) {
            throw new ArgumentException("Email организации не может быть пустым");
        }

        if (empty($arSiteSettingsFields[self::FIELD_PHONE_CODE])) {
            throw new ArgumentException("Телефон организации не может быть пустым");
        }

        if (empty($arSiteSettingsFields[self::FIELD_ADDRESS_CODE])) {
            throw new ArgumentException("Адрес организации не может быть пустым");
        }
    }

    /**
     * @param array $arSiteSettingsFields
     * @return array
     * @throws ArgumentException
     * @throws SystemException
     */
    protected function compareFieldsArray(array $arSiteSettingsFields): array
    {
        foreach ($arSiteSettingsFields as $key => $field) {
            if (!(str_contains($key, self::VALUE_STR_CONTAIN) || str_contains($key, self::LABEL_STR_CONTAIN))) {
                continue;
            }

            switch (true) {
                case str_contains($key, self::FIELD_ADDRESS_ORGANISATION_CODE) && !array_key_exists(self::FIELD_ADDRESS_ORGANISATION_CODE, $arSiteSettingsFields):
                    $arSiteSettingsFields = $this->compareMultipleField($arSiteSettingsFields, self::FIELD_ADDRESS_ORGANISATION_CODE);
                    break;
                case str_contains($key, self::FIELD_CONTACT_PHONES_CODE) && !array_key_exists(self::FIELD_CONTACT_PHONES_CODE, $arSiteSettingsFields):
                    $arSiteSettingsFields = $this->compareMultipleField($arSiteSettingsFields, self::FIELD_CONTACT_PHONES_CODE);
                    break;
                case str_contains($key, self::FIELD_SOCIAL_NETWORKS_CODE) && !array_key_exists(self::FIELD_SOCIAL_NETWORKS_CODE, $arSiteSettingsFields):
                    $arSiteSettingsFields = $this->compareMultipleField($arSiteSettingsFields, self::FIELD_SOCIAL_NETWORKS_CODE);
                    break;
                case str_contains($key, self::FIELD_SOCIAL_NETWORKS_FOOTER_CODE) && !array_key_exists(self::FIELD_SOCIAL_NETWORKS_FOOTER_CODE, $arSiteSettingsFields):
                    $arSiteSettingsFields = $this->compareMultipleField($arSiteSettingsFields, self::FIELD_SOCIAL_NETWORKS_FOOTER_CODE);
                    break;
                case str_contains($key, self::FIELD_MAP_COORDINATES_CODE) && !array_key_exists(self::FIELD_MAP_COORDINATES_CODE, $arSiteSettingsFields):
                    $arSiteSettingsFields = $this->compareMapCoors($arSiteSettingsFields);
                    break;
                default:
                    break;
            }
        }

        // TODO - посмотреть почему иногда дублируются файлы при удалении
        if (!empty($arSiteSettingsFields[self::FIELD_LOGO_CODE])) {
            $arSiteSettingsFields = $this->uploadFile($arSiteSettingsFields, self::FIELD_LOGO_CODE);
        }
        if (!empty($arSiteSettingsFields[self::FIELD_LOGO_FOOTER_CODE])) {
            $arSiteSettingsFields = $this->uploadFile($arSiteSettingsFields, self::FIELD_LOGO_FOOTER_CODE);
        }

        return $arSiteSettingsFields;
    }

    /**
     * @param array $arSiteSettingsFields
     * @param string $prefixCode
     * @return array
     */
    protected function compareMultipleField(array $arSiteSettingsFields, string $prefixCode): array
    {
        $arFields = array_filter($arSiteSettingsFields, function ($item, $key) use ($prefixCode) {
            return str_contains($key, $prefixCode."_".self::VALUE_STR_CONTAIN) || str_contains($key, $prefixCode."_".self::LABEL_STR_CONTAIN);
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($arSiteSettingsFields)) {
            return $arSiteSettingsFields;
        }

        $arLabels = array_values(array_filter($arFields, function ($item, $key) {
            return str_contains($key, self::LABEL_STR_CONTAIN);
        }, ARRAY_FILTER_USE_BOTH));
        $arValues = array_values(array_filter($arFields, function ($item, $key) {
            return str_contains($key, self::VALUE_STR_CONTAIN);
        }, ARRAY_FILTER_USE_BOTH));

        $result = [];
        foreach ($arLabels as $key => $label) {
            !empty($label) && !empty($arValues[$key]) && $result[$label] = $arValues[$key];
        }

        if (!empty($result)) {
            $arSiteSettingsFields = array_filter($arSiteSettingsFields, function ($item, $key) use ($prefixCode) {
                return !(str_contains($key, $prefixCode."_".self::VALUE_STR_CONTAIN) || str_contains($key, $prefixCode."_".self::LABEL_STR_CONTAIN));
            }, ARRAY_FILTER_USE_BOTH);
            $arSiteSettingsFields[$prefixCode] = $result;
        }

        return $arSiteSettingsFields;
    }

    /**
     * @param array $arSiteSettingsFields
     * @return array
     * @throws ArgumentException
     */
    protected function compareMapCoors(array $arSiteSettingsFields): array
    {
        if (empty($arSiteSettingsFields[self::FIELD_MAP_COORDINATES_CODE."_VALUE_1"]) || empty($arSiteSettingsFields[self::FIELD_MAP_COORDINATES_CODE."_VALUE_2"])) {
            throw new ArgumentException("Необходимо ввести 2 координаты для точки на карте");
        }

        $arSiteSettingsFields[self::FIELD_MAP_COORDINATES_CODE][] = (float) $arSiteSettingsFields[self::FIELD_MAP_COORDINATES_CODE."_".self::VALUE_STR_CONTAIN."_1"];
        $arSiteSettingsFields[self::FIELD_MAP_COORDINATES_CODE][] = (float) $arSiteSettingsFields[self::FIELD_MAP_COORDINATES_CODE."_".self::VALUE_STR_CONTAIN."_2"];
        unset($arSiteSettingsFields[self::FIELD_MAP_COORDINATES_CODE."_".self::VALUE_STR_CONTAIN."_1"]);
        unset($arSiteSettingsFields[self::FIELD_MAP_COORDINATES_CODE."_".self::VALUE_STR_CONTAIN."_2"]);

        return $arSiteSettingsFields;
    }

    /**
     * @param array $arSiteSettingsFields
     * @param string $fieldCode
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    protected function uploadFile(array $arSiteSettingsFields, string $fieldCode): array
    {
        if (!empty($arSiteSettingsFields[$fieldCode]["error"])) {
            unset($arSiteSettingsFields[$fieldCode]);
            return $arSiteSettingsFields;
        }
        $this->deleteFieldFile($fieldCode);
        $arSiteSettingsFields[$fieldCode] = CFile::SaveFile($arSiteSettingsFields[$fieldCode], Manager::SITE_SETTINGS_FILE_PATH);
        return $arSiteSettingsFields;
    }

    /**
     * @param string $fieldCode
     * @return void
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    protected function deleteFieldFile(string $fieldCode): void
    {
        if (empty($fieldCode)) {
            throw new ArgumentException("Не введён код поля для удаления файла");
        }

        $query = new Query(SiteSettingsTable::getEntity());
        $query->setOrder(["ID" => "ASC"]);
        $query->setFilter(["=SITE_ID" => "s1"]);
        $query->setLimit(1);
        $query->setSelect([$fieldCode]);
        $result = $query->exec();
        $rows = $result->fetchAll();

        foreach ($rows as $row) {
            !empty($row[$fieldCode]) && CFile::Delete($row[$fieldCode]);
        }
    }
}