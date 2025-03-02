<?php

namespace Robot\Core\Entity\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

final class ProgramListReqParam
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
    /** @var string Дата проведения события */
    private string $requestStartDate;
    private string $requestEndDate;

    private const LOCATION_PROP_CODE = "PROPERTY_LOCATION";
    private const DATE_TIME_PROP_CODE = "PROPERTY_DATE_TIME";
    private const TIME_PROP_CODE = "PROPERTY_TIME";

    /**
     * @param string $iblockType
     * @param int $iblockId
     * @param int[] $sectionsIds
     * @param DateTime $date
     * @param bool $active
     * @param string $sort
     * @throws ArgumentException
     */
    public function __construct(
        string $iblockType,
        int $iblockId,
        array $sectionsIds,
        DateTime $date,
        bool $active = false,
        string $sort = 'DESC'
    )
    {
        if (empty($iblockType) || empty($iblockId) || empty($sectionsIds) || empty($date)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }
        $this->iblockType = $iblockType;
        $this->iblockId = $iblockId;
        $this->sectionsIds = $sectionsIds;
        $formattedDate = $date->format("Y-m-d");
        $this->requestStartDate = $formattedDate . " 00:00:00";
        $this->requestEndDate = $formattedDate . " 23:59:59";
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
            "SECTION_ID" => $this->sectionsIds,
            ">=".self::DATE_TIME_PROP_CODE => $this->requestStartDate,
            "<=".self::DATE_TIME_PROP_CODE => $this->requestEndDate
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
            "ID",
            "NAME",
            self::LOCATION_PROP_CODE,
            self::TIME_PROP_CODE
        ];
    }
}