<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Параметры запроса для получения активного события
*/
final class ActiveEventReqParams
{
    /** @var string Тип ИБ */
    private string $iblockType;
    /** @var int Id ИБ */
    private int $iblockId;
    /** @var bool Сотояние активности элемента */
    private bool $active;
    /** @var string Способ сортировки */
    private string $sort;

    /** @var string Сортируемое свойство Дата проведения */
    private const EXPIRATION_DATE_PROP_CODE = "PROPERTY_EXPIRATION_DATE";

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
        bool $active = false,
        string $sort = 'DESC'
    )
    {
        if (empty($iblockType) || empty($iblockId)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }
        $this->iblockType = $iblockType;
        $this->iblockId = $iblockId;
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
            "ACTIVE" => $this->getActiveRequestValue()
        ];
    }

    /**
     * @return string[]
     */
    public function getSortValues(): array
    {
        return [
            self::EXPIRATION_DATE_PROP_CODE => $this->sort
        ];
    }

    /**
     * @return string[]
     */
    public function getSelectedFields(): array
    {
        return [
            "ID",
            "PROPERTY_ACTIVE_REGISTRATION",
            "PROPERTY_EXPIRATION_DATE"
        ];
    }
}