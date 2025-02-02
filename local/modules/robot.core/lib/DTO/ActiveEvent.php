<?php

namespace Robot\Core\DTO;

use Bitrix\Main\Type\DateTime;

final class ActiveEvent
{
    public function __construct(
        public int $id,
        public DateTime $expirationDate,
        public bool $isRegister
    )
    {
    }
}