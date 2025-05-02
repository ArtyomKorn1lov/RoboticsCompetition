<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;
use CUtil;

use Robot\Core\Constants;
use Robot\Core\Tools\IBlocks\Helper;
use Robot\Core\DTO\Event\RegisterExternalData;
use Robot\Core\DTO\Event\FormField;
use Robot\Core\DTO\Event\FormFieldValues;

Loc::loadMessages(__FILE__);

final class RegisterForm
{
    /** @var FormField[] Поля формы */
    private array $fields = [];

    /** @var array Данные формы */
    private array $formData;

    /** @var string Регулярное выражение для валидации email */
    protected const EMAIL_REGULAR_EXPRESSION = '/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i';

    /** @var string Регулярное выражение для валидации номера телефона */
    protected const PHONE_REGULAR_EXPRESSION = '/^(\+7\(\d{3}\)-\d{3}-\d{2}-\d{2})$/';

    /** @var string Префикс для определения кода как свойства */
    protected const PROPERTY_PREFIX_CODE = "PROPERTY_";

    /** @var string[] Параметры для генерации символьного кода */
    protected const CODE_FIELD_GENERATE_PARAMS = [
        "max_len" => "100",
        "change_case" => "L",
        "replace_space" => "_",
        "replace_other" => "_",
        "delete_repeat_replace" => "true",
        "use_google" => "false",
    ];

    /** @var string Код свойства "Привязка к событию" */
    protected const EVENT_PROP_CODE = "EVENT";

    /**
     * @param FormField[] $fields
     * @param array $formData
     * @param RegisterExternalData $externalData
     * @throws ArgumentException
     */
    public function __construct(
        array                $fields,
        array                $formData,
        RegisterExternalData $externalData
    )
    {
        if (empty($externalData->eventId)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_EVENT_NOT_FOUND"));
        }

        if (!empty($fields)) {
            $this->fields = $fields;
        }

        $formData = $this->validateFields($formData);
        $this->prepareSaveFormData($formData, $externalData);
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }

    /**
     * @param array $formData
     * @return array
     * @throws ArgumentException
     */
    protected function validateFields(array $formData): array
    {
        foreach ($this->fields as $field) {

            if (!$field->required) {
                continue;
            }

            if ($field->code === 'agreement') {
                if (empty($formData[$field->code])) {
                    throw new ArgumentException(Loc::getMessage("ROBOT_CORE_AGREEMENT_ERROR"));
                }
                unset($formData[$field->code]);
                continue;
            }

            if (empty($formData[$field->code])) {
                throw new ArgumentException(Loc::getMessage("ROBOT_CORE_REQUIRED_ERROR", ["#NAME#" => $field->title]));
            }

            switch ($field->type) {
                case "autocomplete":
                    if (!$this->validateAutocompleteField($formData[$field->code], $field->values)) {
                        throw new ArgumentException(Loc::getMessage("ROBOT_CORE_AUTOCOMPLETE_ERROR", ["#NAME#" => $field->title]));
                    }
                    break;
                case "tel":
                    if (!preg_match(self::PHONE_REGULAR_EXPRESSION, $formData[$field->code])) {
                        throw new ArgumentException(Loc::getMessage("ROBOT_CORE_FIELD_VALUE_ERROR", ["#NAME#" => $field->title]));
                    }
                    break;
                case "email":
                    if (!preg_match(self::EMAIL_REGULAR_EXPRESSION, $formData[$field->code])) {
                        throw new ArgumentException(Loc::getMessage("ROBOT_CORE_FIELD_VALUE_ERROR", ["#NAME#" => $field->title]));
                    }
                    break;
                default:
                    break;
            }
        }

        return $formData;
    }

    /**
     * @param string $value
     * @param FormFieldValues[] $items
     * @return bool
     */
    protected function validateAutocompleteField(string $value, array $items): bool
    {
        foreach ($items as $item) {
            if ($item->name === trim($value)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $formData
     * @param RegisterExternalData $externalData
     * @return void
     */
    protected function prepareSaveFormData(array $formData, RegisterExternalData $externalData): void
    {
        $formData = $this->comparePropertyArray($formData);

        $formData["PROPERTY_VALUES"][self::EVENT_PROP_CODE] = $externalData->eventId;
        $formData["IBLOCK_TYPE"] = Constants::FEEDBACK_IBLOCK_TYPE;
        $formData["IBLOCK_ID"] = Helper::getIblock(Constants::REGISTRATION_REQUEST_IBLOCK_CODE);
        $formData["ACTIVE"] = "Y";
        $externalData->lastElementId++;
        $formData["NAME"] = Loc::getMessage("ROBOT_CORE_NEW_REQUEST_TITLE", ["#NUMBER#" => $externalData->lastElementId]);
        $formData["CODE"] = Cutil::translit($formData["NAME"], LANGUAGE_ID, self::CODE_FIELD_GENERATE_PARAMS);

        $this->formData = $formData;
    }

    /**
     * @param array $formData
     * @return array
     */
    protected function comparePropertyArray(array $formData): array
    {
        foreach ($formData as $key => $item) {
            if (!str_contains($key, self::PROPERTY_PREFIX_CODE)) {
                continue;
            }

            $newKeyCode = str_replace(self::PROPERTY_PREFIX_CODE, '', $key);
            $formData["PROPERTY_VALUES"][$newKeyCode] = $item;
            unset($formData[$key]);
        }
        return $formData;
    }
}