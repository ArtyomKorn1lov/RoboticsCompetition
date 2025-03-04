<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use Robot\Core\Constants;
use Robot\Core\Tools\IBlocks\Helper;

final class RegisterForm
{
    private array $formData;

    /**
     * @param array $fields
     * @param array $formData
     * @throws ArgumentException
     */
    public function __construct(
        array $fields,
        array $formData
    )
    {
        $this->validateFields($fields, $formData);
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }

    /**
     * @param array $fields
     * @param array $formData
     * @return void
     * @throws ArgumentException
     */
    protected function validateFields(array $fields, array $formData): void
    {
        foreach ($fields as $field) {

            if (!$field["required"]) {
                continue;
            }

            if ($field["code"] === 'agreement') {
                if (empty($formData[$field["code"]])) {
                    throw new ArgumentException("Не отмечен чекбокс согласия на обработку перс. данных");
                }
                unset($formData[$field["code"]]);
                continue;
            }

            if (empty($formData[$field["code"]])) {
                throw new ArgumentException('Поле "' . $field["title"] . '" обязательно для заполнения');
            }

            switch ($field["type"]) {
                case "autocomplete":
                    if (!in_array($formData[$field["code"]], $field["items"])) {
                        throw new ArgumentException('Не выбрано значение поля "' . $field["title"] . '"');
                    }
                    break;
                case "tel":
                    break;
                case "email":
                    break;
                default:
                    break;
            }
        }

        $formData["IBLOCK_TYPE"] = Constants::FEEDBACK_IBLOCK_TYPE;
        $formData["IBLOCK_ID"] = Helper::getIblock(Constants::REGISTRATION_REQUEST_IBLOCK_CODE);
        $formData["ACTIVE"] = "Y";
        $formData["NAME"] = "Заявка с формы обратной связи";

        $this->formData = $formData;
    }
}