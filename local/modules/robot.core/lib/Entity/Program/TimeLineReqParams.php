<?php

namespace Robot\Core\Entity\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;

/**
 * Параметры запроса для получения списка дат события
 */
final class TimeLineReqParams
{
    /** @var string Тип ИБ */
    private string $iblockType;
    /** @var int Id ИБ */
    private int $iblockId;
    /** @var bool Сотояние активности элемента */
    private bool $active;
    /** @var string Способ сортировки */
    private string $sort;
    /** @var int[] Список id разделов для выборки */
    private array $sectionsIds;

    private const DATE_TIME_PROP_CODE = "PROPERTY_DATE_TIME";

    /**
     * @param string $iblockType
     * @param int $iblockId
     * @param int[] $sectionsIds
     * @param bool $active
     * @param string $sort
     * @throws ArgumentException
     */
    public function __construct(
        string $iblockType,
        int $iblockId,
        array $sectionsIds,
        bool $active = false,
        string $sort = 'DESC'
    )
    {
        if (empty($iblockType) || empty($iblockId) || empty($sectionsIds)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }
        $this->iblockType = $iblockType;
        $this->iblockId = $iblockId;
        $this->sectionsIds = $sectionsIds;
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
            "SECTION_ID" => $this->sectionsIds
        ];
    }

    /**
     * @return string[]
     */
    public function getSortValues(): array
    {
        return [
            self::DATE_TIME_PROP_CODE => $this->sort,
            "SORT" => $this->sort
        ];
    }

    /**
     * @return string[]
     */
    public function getSelectedFields(): array
    {
        return [
            self::DATE_TIME_PROP_CODE
        ];
    }

    /**
     * @return string
     */
    public function getSamplePropCode(): string
    {
        return self::DATE_TIME_PROP_CODE."_VALUE";
    }
}