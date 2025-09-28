<?php

namespace Robot\Core\Entity\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\Type\DateTime;
use Robot\Core\Exceptions\RobotException;

final class DateUnit
{
    /** @var DateTime Объект даты */
    private DateTime $date;
    /** @var string Строка даты для вывода в публичке */
    private string $dateString;

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getDateString(): string
    {
        return $this->dateString;
    }

    /**
     * @param string $date
     * @throws ArgumentException
     * @throws ObjectException
     * @throws RobotException
     */
    public function __construct(
        string $date
    )
    {
        if (empty($date)) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }

        $this->date = new DateTime($this->cutTimeOption($date));
        $this->dateString = FormatDate("d F", $this->date->getTimestamp());
    }

    /**
     * @return string
     */
    public function getDefaultDateString(): string
    {
        return FormatDate("DD.MM.YYYY", $this->date->getTimestamp());
    }

    /**
     * @return string
     */
    public function getFormattedString(): string
    {
        return $this->date->format("d.m.Y H:i:s");
    }

    /**
     * @param string $date
     * @return string
     * @throws RobotException
     */
    protected function cutTimeOption(string $date): string
    {
        $arData = explode(" ", $date);

        if (empty($arData[0])) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_DATES_EMPTY_EXCEPTION"));
        }

        return $arData[0] . " 00:00:00";
    }
}