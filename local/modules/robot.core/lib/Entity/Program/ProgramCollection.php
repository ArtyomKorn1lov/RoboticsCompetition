<?php

namespace Robot\Core\Entity\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

final class ProgramCollection
{
    /** @var Program[] Список программ */
    private array $programs;

    /**
     * @return Program[]
     */
    public function getList(): array
    {
        return $this->programs;
    }

    /**
     * @param array $programs
     * @throws ArgumentException
     */
    public function __construct(
        array $programs
    )
    {
        if (empty($programs)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }

        $this->programs = [];
        foreach ($programs as $program) {
            $this->programs[] = new Program(
                $program["ID"],
                $program["NAME"],
                $program["PROPERTY_LOCATION_VALUE"],
                $program["PROPERTY_TIME_VALUE"]
            );
        }
    }
}