<?php

namespace Robot\Core\DTO\Event;

final class RegisterForm
{
    public function __construct(
        public array $formData
    )
    {
    }
}