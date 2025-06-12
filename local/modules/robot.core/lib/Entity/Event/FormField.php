<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\LoaderException;

use Robot\Core\Base\HighloadBlocks;
use Robot\Core\Constants;
use Robot\Core\Tools\Mappers\Event;

Loc::loadMessages(__FILE__);

final class FormField extends HighloadBlocks
{
    /** @var int Id поля формы */
    private int $id;

    /** @var string Код поля формы */
    private string $code;

    /** @var string Название поля формы */
    private string $title;

    /** @var string Тип поля формы */
    private string $type;

    /** @var string Плейсхолдер поля формы */
    private string $placeholder;

    /** @var bool Флаг обязательного поля */
    private bool $required;

    /** @var FormFieldValuesCollection значения для полей select и autocomplete  */
    private FormFieldValuesCollection $values;

    /**
     * @param int $id
     * @param string $code
     * @param string $type
     * @param bool $required
     * @param string $title
     * @param string $placeholder
     * @param string $entityName
     * @param bool $isInit
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws LoaderException
     */
    public function __construct(
        int $id,
        string $code,
        string $type,
        bool $required = false,
        string $title = "",
        string $placeholder = "",
        string $entityName = "",
        bool $isInit = true
    )
    {
        if (!$this->validateValues($id, $code, $type)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }
        $this->values = new FormFieldValuesCollection();

        $this->id = $id;
        $this->type = $type;
        $this->code = $code;
        $this->required = $required;
        $this->title = $title;
        $this->placeholder = $placeholder;

        $this->setEntityValues($entityName, $isInit);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * @return bool
     */
    public function getRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return FormFieldValuesCollection
     */
    public function getValues(): FormFieldValuesCollection
    {
        return $this->values;
    }

    /**
     * @param int $id
     * @param string $code
     * @param string $type
     * @return bool
     */
    protected function validateValues(
        int $id,
        string $code,
        string $type,
    ): bool
    {
        return !empty($id) && !empty($code) && !empty($type);
    }

    /**
     * @param string $entityName
     * @param bool $isInit
     * @return void
     * @throws ArgumentException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws LoaderException
     */
    protected function setEntityValues(string $entityName, bool $isInit): void
    {
        if (empty($entityName) || ($this->type === Constants::CODE_FIELD_AUTOCOMPLETE && $isInit)) {
            return;
        }

        $arData = $this->getEntityItemsByName(
            $entityName,
            [
                Constants::UF_FIELD_CODE_ID,
                Constants::UF_FIELD_CODE_CODE,
                Constants::UF_FIELD_CODE_VALUE
            ],
            [
                Constants::UF_FIELD_CODE_SORT => "ASC"
            ]
        );
        if (empty($arData)) {
            return;
        }
        $this->values = Event::mapFormFieldValuesArrayToEntityList($arData);
    }
}