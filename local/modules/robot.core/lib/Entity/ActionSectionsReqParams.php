<?php

namespace Robot\Core\Entity;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Параметры запроса для получения списка id разделов мероприятий активного события
 */
final class ActionSectionsReqParams
{
    /** @var string Тип ИБ */
    private string $iblockType;
    /** @var int Id ИБ */
    private int $iblockId;
    /** @var bool Сотояние активности элемента */
    private bool $active;
    /** @var string Способ сортировки */
    private string $sort;
    /** @var int Id события */
    private int $eventId;

    private const UF_EVENT_ID_CODE = "UF_EVENTS";

    /**
     * @param string $iblockType
     * @param int $iblockId
     * @param bool $active
     * @param string $sort
     * @throws ArgumentException
     */
    public function __construct(
        string $iblockType,
        int $iblockId,
        int $eventId,
        bool $active = false,
        string $sort = 'DESC'
    )
    {
        if (empty($iblockType) || empty($iblockId)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }
        $this->iblockType = $iblockType;
        $this->iblockId = $iblockId;
        $this->eventId = $eventId;
        $this->active = $active;
        $this->sort = $sort;
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
            "ACTIVE" => $this->getActiveRequestValue(),
            self::UF_EVENT_ID_CODE => $this->eventId
        ];
    }

    /**
     * @return string[]
     */
    public function getSortValues(): array
    {
        return [
            "SORT" => $this->sort
        ];
    }

    /**
     * @return string[]
     */
    public function getSelectedFields(): array
    {
        return [
            "ID",
        ];
    }
}