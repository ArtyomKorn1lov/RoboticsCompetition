<?php

namespace Robot\Core\DTO\Event;

use Bitrix\Main\Type\DateTime;

final class ActiveEvent
{
    /**
     * @param int $id
     * @param DateTime $expirationDate
     * @param bool $isRegister
     */
    public function __construct(
        public int $id,
        public DateTime $expirationDate,
        public bool $isRegister
    )
    {
    }
}