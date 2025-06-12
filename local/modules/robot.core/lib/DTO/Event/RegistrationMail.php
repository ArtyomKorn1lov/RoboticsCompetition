<?php

namespace Robot\Core\DTO\Event;

final class RegistrationMail
{
    /**
     * @param string $eventName
     * @param string $name
     * @param string $birthday
     * @param string $country
     * @param int|null $course
     * @param int|null $codeAndAreaTraining
     * @param string $phone
     * @param string $email
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
        public ?int $course,
        public ?int $codeAndAreaTraining,
        public ?string $description,
        public ?string $editUrl
    )
    {
    }
}