<?php

namespace Robot\Core\Entity\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use stdClass;

Loc::loadMessages(__FILE__);

final class Program
{
    /** @var int Id */
    public readonly int $id;
    /** @var string Название */
    public readonly string $name;
    /** @var string Место проведения */
    public readonly string $location;
    /** @var string Начало проведения */
    private readonly string $timeFrom;
    /** @var string Конец проведения */
    private readonly string $timeTo;

    /**
     * @param int $id
     * @param string $name
     * @param string $location
     * @param string $timeSerialised
     * @throws ArgumentException
     */
    public function __construct(
        int $id,
        string $name,
        string $location,
        string $timeSerialised
    )
    {
        if (!$this->validateParams($id, $name, $location)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }

        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->unserializeTimeRange($timeSerialised);
    }

    /**
     * @return string
     */
    public function getTimeRange(): string
    {
        if (empty($this->timeFrom) || empty($this->timeTo)) {
            return "";
        }

        return $this->timeFrom . " - " . $this->timeTo;
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $location
     * @return bool
     */
    protected function validateParams(
        string $id,
        string $name,
        string $location
    ): bool
    {
        return !(empty($id) || empty($name) || empty($location));
    }

    /**
     * @param string $timeSerialised
     * @return void
     */
    protected function unserializeTimeRange(string $timeSerialised): void
    {
        if (empty($timeSerialised)) {
            return;
        }

        $arValue = unserialize(htmlspecialcharsback($timeSerialised), [stdClass::class]);

        if (empty($arValue["TIME_FROM"]) || empty($arValue["TIME_TO"])) {
            $this->timeFrom = "";
            $this->timeTo = "";
            return;
        }

        $this->timeFrom = $arValue["TIME_FROM"];
        $this->timeTo = $arValue["TIME_TO"];
    }
}