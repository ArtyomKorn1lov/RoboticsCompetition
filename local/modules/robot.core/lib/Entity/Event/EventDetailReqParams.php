<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\Localization\Loc;
use Robot\Core\Exceptions\RobotException;

final class EventDetailReqParams
{
    /** @var string Тип ИБ */
    private string $iblockType;
    /** @var int Id ИБ */
    private int $iblockId;
    /** @var int Id элемента */
    private int $id;
    /** @var bool Сотояние активности элемента */
    private bool $active;

    /**
     * @param string $iblockType
     * @param int $iblockId
     * @param int $id
     * @param bool $active
     * @throws RobotException
     */
    public function __construct(
        string $iblockType,
        int $iblockId,
        int $id,
        bool $active = false
    )
    {
        if (empty($iblockType) || empty($iblockId)) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }
        $this->iblockType = $iblockType;
        $this->iblockId = $iblockId;
        $this->id = $id;
        $this->active = $active;
    }

    /**
     * @return string
     */
    protected function getActiveRequestValue(): string
    {
        return $this->active ? "Y" : "N";
    }

    /**
     * @return array
     */
    public function getFilterValues(): array
    {
        return [
            "IBLOCK_TYPE" => $this->iblockType,
            "IBLOCK_ID" => $this->iblockId,
            "ID" => $this->id,
            "ACTIVE" => $this->getActiveRequestValue()
        ];
    }

    /**
     * @return string[]
     */
    public function getSortValues(): array
    {
        return [
            "ID" => "DESC"
        ];
    }

    /**
     * @return string[]
     */
    public function getSelectedFields(): array
    {
        return [
            "ID",
            "NAME"
        ];
    }
}