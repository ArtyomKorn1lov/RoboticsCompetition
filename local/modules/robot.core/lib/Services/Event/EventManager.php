<?php

namespace Robot\Core\Services\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\SystemException;
use Robot\Core\DTO\Event\RegisterExternalData;
use Robot\Core\DTO\Event\RegisterForm;
use Robot\Core\Entity\Event\RegisterForm as RegisterFormEntity;
use Robot\Core\Repositories\Event\EventRepository;

class EventManager implements IEventManager
{
    /**
     * @param RegisterForm $registerForm
     * @param int $eventId
     * @return void
     * @throws ArgumentException
     * @throws ObjectException
     * @throws SystemException
     */
    public function saveForm(RegisterForm $registerForm, int $eventId): void
    {
        try {
            if (empty($eventId)) {
                throw new ArgumentException("Указанного события не существует");
            }

            $fields = $this->getFormFields();
            if (empty($fields)) {
                throw new SystemException("Ошибка получения полей формы");
            }

            // TODO вынести в сервис-локатор
            $eventRepository = new EventRepository();
            $lastElementId = $eventRepository->getLastElementId();

            $externalData = new RegisterExternalData(
                eventId: $eventId,
                lastElementId: $lastElementId
            );
            $entity = new RegisterFormEntity(
                $fields,
                $registerForm->formData,
                $externalData
            );
            $eventRepository->saveForm($entity);
        } catch (SystemException|ArgumentException|ObjectException $exception) {
            AddMessage2Log($exception->getMessage(), 'robot.core');
            throw $exception;
        }
    }

    /**
     * TODO получать поля из БД, добавить DTO-шки полей
     * @return array[]
     */
    protected function getFormFields(): array
    {
        return [
            [
                "code" => "PROPERTY_NAME",
                "title" => "ФИО участника",
                "type" => "text",
                "required" => true
            ],
            [
                "code" => "PROPERTY_BIRTHDAY",
                "title" => "Дата рождения",
                "type" => "date",
                "required" => true
            ],
            [
                "code" => "PROPERTY_COUNTRY",
                "title" => "Страна",
                "type" => "autocomplete",
                "required" => true,
                "items" => [
                    'Российская федерация',
                    'Республика Таджикистан',
                    'Республика Узбекистан',
                    'Республика Беларусь',
                    'Республика Китай'
                ]
            ],
            [
                "code" => "PROPERTY_COURSE",
                "title" => "Курс",
                "type" => "text",
                "required" => false
            ],
            [
                "code" => "PROPERTY_CODE_AND_AREA_TRAINING",
                "title" => "Шифр и наименование направления подготовки",
                "type" => "text",
                "required" => false
            ],
            [
                "code" => "PROPERTY_PHONE",
                "title" => "Телефон",
                "type" => "tel",
                "required" => true
            ],
            [
                "code" => "PROPERTY_EMAIL",
                "title" => "E-mail",
                "type" => "email",
                "required" => true
            ],
            [
                "code" => "PREVIEW_TEXT",
                "title" => "Комментарий",
                "type" => "textarea",
                "required" => false
            ],
            [
                "code" => "agreement",
                "type" => "checkbox",
                "required" => true
            ],
        ];
    }
}