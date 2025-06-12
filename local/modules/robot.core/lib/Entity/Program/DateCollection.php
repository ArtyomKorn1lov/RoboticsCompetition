<?php

namespace Robot\Core\Entity\Program;

use Robot\Core\Base\Collection;

/**
 * Коллекция объектов класса DateUnit
 * @implements Collection<DateUnit>
 */
final class DateCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return DateUnit::class;
    }

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    /**
     * @return void
     */
    public function compareUnicDates(): void
    {
        $unicDates = [];
        $dateUnits = [];
        foreach ($this->items() as $date) {
            $formatedDate = $date->getDefaultDateString();
            if (in_array($formatedDate, $unicDates)) {
                continue;
            }
            $unicDates[] = $formatedDate;
            $dateUnits[] = $date;
        }
        $this->replace(new DateCollection($dateUnits));
    }
}