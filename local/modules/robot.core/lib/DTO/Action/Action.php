<?php

namespace Robot\Core\DTO\Action;

final class Action
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description
    )
    {
    }
}