<?php

namespace Robot\Core\DTO\Event;

final class FormFieldValues
{
    public function __construct(
        public int $id,
        public string $code,
        public string $name
    )
    {
    }
}