<?php

namespace Robot\Core\Entity\Action;

use Bitrix\Main\Localization\Loc;
use Robot\Core\Exceptions\RobotException;

Loc::loadMessages(__FILE__);

/**
 * Параметры запроса для получения списка мероприятий по Id разделов
 */
final class ActionItemsReqParams
{
    /** @var string Тип ИБ */
    private string $iblockType;
    /** @var int Id ИБ */
    private int $iblockId;
    /** @var bool Сотояние активности элемента */
    private bool $active;
    /** @var string Способ сортировки */
    private string $sort;
    /** @var int[] Список Id разделов для фильтрации */
    private array $sectionsIds;

    /**
     * @param string $iblockType
     * @param int $iblockId
     * @param array $sectionsIds
     * @param bool $active
     * @param string $sort
     * @throws RobotException
     */
    public function __construct(
        string $iblockType,
        int $iblockId,
        array $sectionsIds,
        bool $active = false,
        string $sort = 'DESC'
    )
    {
        if (empty($iblockType) || empty($iblockId)) {
            throw new RobotException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
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
            "DETAIL_TEXT"
        ];
    }
}