<?php

namespace Robot\Core\Tools\Mappers;

use Bitrix\Main\ObjectException;
use Bitrix\Main\Type\DateTime;

use Robot\Core\DTO\ActiveEvent;

class Event
{
    /**
     * @param string $flag
     * @return bool
     */
    protected static function compareStringFlagToBool(string $flag): bool
    {
        return $flag === "Y";
    }

    /**
     * @param array $response
     * @return ActiveEvent
     * @throws ObjectException
     */
    public static function mapActiveEventResponseToModel(array $response): ActiveEvent
    {
        return new ActiveEvent(
            $response["ID"],
            new DateTime($response["PROPERTY_EXPIRATION_DATE_VALUE"]),
            static::compareStringFlagToBool($response["PROPERTY_ACTIVE_REGISTRATION_VALUE"])
        );
    }
}