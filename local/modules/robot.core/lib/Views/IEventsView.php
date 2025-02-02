<?php

namespace Robot\Core\Views;

use Robot\Core\DTO\Action;

interface IEventsView
{
    /**
     * @return bool
     */
    public static function showRegistration(): bool;

    /**
     * @return bool
     */
    public static function showProgram(): bool;

    /**
     * @return int|bool
     */
    public static function getActiveEventId(): int|bool;

    /**
     * @return array<Action>|bool
     */
    public static function getEventActions(): array|bool;
}