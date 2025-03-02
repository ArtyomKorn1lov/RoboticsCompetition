<?php

namespace Robot\Core\Entity\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;

final class DateCollection
{
    /** @var DateUnit[]  */
    private array $dateUnits;

    /**
     * @return DateUnit[]
     */
    public function getList(): array
    {
        return $this->dateUnits;
    }

    /**
     * @param string[] $dates
     * @throws ArgumentException|ObjectException
     */
    public function __construct(
        array $dates
    )
    {
        if (empty($dates)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }

        $this->compareUnicDates($dates);
    }

    /**
     * @param int $index
     * @return DateUnit
     * @throws ObjectException
     */
    public function getDateUnicByIndex(int $index): DateUnit
    {
        if (!array_key_exists($index, $this->dateUnits)) {
            throw new ObjectException(Loc::getMessage("ROBOT_CORE_ELEMENT_NOT_EXIST_EXCEPTION"));
        }
        return $this->dateUnits[$index];
    }

    /**
     * @param string[] $dates
     * @return void
     * @throws ArgumentException
     * @throws ObjectException
     */
    protected function compareUnicDates(array $dates): void
    {
        $unicDates = [];
        $this->dateUnits = [];
        foreach ($dates as $date) {
            $dateUnit = new DateUnit($date);
            $formatedDate = $dateUnit->getDefaultDateString();
            if (in_array($formatedDate, $unicDates)) {
                continue;
            }
            $unicDates[] = $formatedDate;
            $this->dateUnits[] = $dateUnit;
        }
    }
}