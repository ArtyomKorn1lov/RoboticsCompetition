<?php

namespace Robot\Core\Tools\Mappers;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\Type\DateTime;

use Robot\Core\Constants;
use Robot\Core\DTO\Event\ActiveEvent;
use Robot\Core\DTO\Event\RegisterForm;
use Robot\Core\Entity\Event\FormField as FormFieldEntity;
use Robot\Core\DTO\Event\FormField;
use Robot\Core\Entity\Event\FormFieldValues as FormFieldValuesEntity;
use Robot\Core\DTO\Event\FormFieldValues;
use Robot\Core\DTO\Event\SearchResult;

class Event
{
    /**
     * @param string $flag
     * @return bool
     */
    protected static function compareStringFlagToBool(string $flag): bool
    {
        return $flag === "Y";
    }

    /**
     * @param array $response
     * @return ActiveEvent
     * @throws ObjectException
     */
    public static function mapActiveEventResponseToModel(array $response): ActiveEvent
    {
        return new ActiveEvent(
            id: $response["ID"],
            expirationDate: new DateTime($response["PROPERTY_EXPIRATION_DATE_VALUE"]),
            isRegister: static::compareStringFlagToBool($response["PROPERTY_ACTIVE_REGISTRATION_VALUE"])
        );
    }

    /**
     * @param array $participant
     * @return RegisterForm
     */
    public static function mapRegisterFormArrayToModel(array $participant): RegisterForm
    {
        return new RegisterForm(
            formData: $participant
        );
    }

    /**
     * @param array $data
     * @return FormFieldValuesEntity[]
     * @throws ArgumentException
     */
    public static function mapFormFieldValuesArrayToEntityList(array $data): array
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = new FormFieldValuesEntity(
                $item[Constants::UF_FIELD_CODE_ID],
                $item[Constants::UF_FIELD_CODE_CODE],
                $item[Constants::UF_FIELD_CODE_VALUE]
            );
        }
        return $result;
    }

    /**
     * @param FormFieldEntity[] $entities
     * @return FormField[]
     */
    public static function mapFormFieldListEntityToModelList(array $entities): array
    {
        $result = [];
        foreach ($entities as $entity) {
            $result[] = new FormField(
                id: $entity->getId(),
                code: $entity->getCode(),
                title: $entity->getTitle(),
                type: $entity->getType(),
                placeholder: $entity->getPlaceholder(),
                required: $entity->getRequired(),
                values: static::mapFormFieldValuesListEntityToModelList($entity->getValues())
            );
        }

        return $result;
    }

    /**
     * @param FormFieldValuesEntity[] $entities
     * @return FormFieldValues[]
     */
    public static function mapFormFieldValuesListEntityToModelList(array $entities): array
    {
        $result = [];
        foreach ($entities as $entity) {
            $result[] = new FormFieldValues(
                id: $entity->getId(),
                code: $entity->getCode(),
                name: $entity->getName()
            );
        }
        return $result;
    }

    /**
     * @param string[] $items
     * @return SearchResult[]
     */
    public static function mapSearchResultArrayToModelList(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = new SearchResult(
                value: $item
            );
        }
        return $result;
    }
}