<?php

namespace Robot\Core\DTO\Event;

final class RegistrationMail
{
    /**
     * @param string $eventName
     * @param string $name
     * @param string $birthday
     * @param string $country
     * @param string $phone
     * @param string $email
     * @param string|null $course
     * @param string|null $codeAndAreaTraining
     * @param string|null $description
     * @param string|null $editUrl
     */
    public function __construct(
        public string $eventName,
        public string $name,
        public string $birthday,
        public string $country,
        public string $phone,
        public string $email,
        public ?string $course,
        public ?string $codeAndAreaTraining,
        public ?string $description,
        public ?string $editUrl
    )
    {
    }
}