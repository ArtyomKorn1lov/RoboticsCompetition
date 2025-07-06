<?php

namespace Robot\Core\DTO\Event;

final class RegisterExternalData
{
    /**
     * @param int $eventId
     * @param int $lastElementId
     */
    public function __construct(
        public int $eventId,
        public int $lastElementId
    )
    {
    }
}