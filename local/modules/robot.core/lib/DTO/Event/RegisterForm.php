<?php

namespace Robot\Core\DTO\Event;

final class RegisterForm
{
    /**
     * @param array $formData
     */
    public function __construct(
        public array $formData
    )
    {
    }
}