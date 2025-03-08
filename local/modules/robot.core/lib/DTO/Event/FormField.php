<?php

namespace Robot\Core\DTO\Event;

final class FormField
{
    /**
     * @param int $id
     * @param string $code
     * @param string $title
     * @param string $type
     * @param string $placeholder
     * @param bool $required
     * @param FormFieldValues[] $values
     */
    public function __construct(
        public int $id,
        public string $code,
        public string $title,
        public string $type,
        public string $placeholder,
        public bool $required,
        public array $values = []
    )
    {
    }
}