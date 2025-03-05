<?php

namespace Robot\Core\DTO\Event;

final class RegisterExternalData
{
    public function __construct(
        public int $eventId,
        public int $lastElementId
    )
    {
    }
}