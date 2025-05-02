<?php

namespace Robot\Core\DTO\Event;

final class FormFieldValues
{
    /**
     * @param int $id
     * @param string $code
     * @param string $name
     */
    public function __construct(
        public int $id,
        public string $code,
        public string $name
    )
    {
    }
}