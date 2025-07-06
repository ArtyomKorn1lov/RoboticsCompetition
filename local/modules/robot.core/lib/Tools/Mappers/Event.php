<?php

namespace Robot\Core\Tools\Mappers;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\Type\DateTime;

use Robot\Core\Constants;
use Robot\Core\DTO\Event\ActiveEvent;
use Robot\Core\DTO\Event\RegisterForm;
use Robot\Core\DTO\Event\RegistrationMail;
use Robot\Core\Entity\Event\FormFieldCollection as FormFieldCollectionEntity;
use Robot\Core\DTO\Event\FormField;
use Robot\Core\DTO\Event\FormFieldCollection;
use Robot\Core\Entity\Event\FormFieldValues as FormFieldValuesEntity;
use Robot\Core\Entity\Event\FormFieldValuesCollection as FormFieldValuesCollectionEntity;
use Robot\Core\DTO\Event\FormFieldValues;
use Robot\Core\DTO\Event\FormFieldValuesCollection;
use Robot\Core\DTO\Event\SearchResult;
use Robot\Core\DTO\Event\SearchResultCollection;

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
     * @return FormFieldValuesCollectionEntity
     * @throws ArgumentException
     */
    public static function mapFormFieldValuesArrayToEntityList(array $data): FormFieldValuesCollectionEntity
    {
        $collection = new FormFieldValuesCollectionEntity();
        foreach ($data as $item) {
            $collection->add(new FormFieldValuesEntity(
                $item[Constants::UF_FIELD_CODE_ID],
                $item[Constants::UF_FIELD_CODE_CODE],
                $item[Constants::UF_FIELD_CODE_VALUE]
            ));
        }
        return $collection;
    }

    /**
     * @param FormFieldCollectionEntity $entities
     * @return FormFieldCollection
     */
    public static function mapFormFieldListEntityToModelList(FormFieldCollectionEntity $entities): FormFieldCollection
    {
        $collection = new FormFieldCollection();
        foreach ($entities as $entity) {
            $collection->add(new FormField(
                id: $entity->getId(),
                code: $entity->getCode(),
                title: $entity->getTitle(),
                type: $entity->getType(),
                placeholder: $entity->getPlaceholder(),
                required: $entity->getRequired(),
                values: static::mapFormFieldValuesListEntityToModelList($entity->getValues())
            ));
        }
        return $collection;
    }

    /**
     * @param FormFieldValuesCollectionEntity $entities
     * @return FormFieldValuesCollection
     */
    public static function mapFormFieldValuesListEntityToModelList(FormFieldValuesCollectionEntity $entities): FormFieldValuesCollection
    {
        $collectionModel = new FormFieldValuesCollection();
        foreach ($entities as $entity) {
            $collectionModel->add(new FormFieldValues(
                id: $entity->getId(),
                code: $entity->getCode(),
                name: $entity->getName()
            ));
        }
        return $collectionModel;
    }

    /**
     * @param string[] $items
     * @return SearchResultCollection
     */
    public static function mapSearchResultArrayToModelList(array $items): SearchResultCollection
    {
        $collectionModel = new SearchResultCollection();
        foreach ($items as $item) {
            $collectionModel->add(new SearchResult(
                value: $item
            ));
        }
        return $collectionModel;
    }

    /**
     * @param array $formData
     * @param string $eventName
     * @param string $editUrl
     * @return RegistrationMail
     */
    public static function mapEventRegistrationParamToMailModel(array $formData, string $eventName, string $editUrl): RegistrationMail
    {
        return new RegistrationMail(
            eventName: $eventName,
            name: $formData["PROPERTY_NAME"],
            birthday: $formData["PROPERTY_BIRTHDAY"],
            country: $formData["PROPERTY_COUNTRY"],
            phone: $formData["PROPERTY_PHONE"],
            email: $formData["PROPERTY_EMAIL"],
            course: $formData["PROPERTY_COURSE"],
            codeAndAreaTraining: $formData["PROPERTY_CODE_AND_AREA_TRAINING"],
            description: $formData["PREVIEW_TEXT"],
            editUrl: $editUrl
        );
    }
}