<?php

namespace Robot\Core\DTO\Action;

final class Action
{
    /**
     * @param int $id
     * @param string $name
     * @param string|null $description
     */
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description
    )
    {
    }
}