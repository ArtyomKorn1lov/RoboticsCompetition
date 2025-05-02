<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ArgumentException;

Loc::loadMessages(__FILE__);

final class FormFieldValues
{
    private int $id;

    private string $code;

    private string $name;

    /**
     * @param int $id
     * @param string $code
     * @param string $name
     * @throws ArgumentException
     */
    public function __construct(
        int $id,
        string $code,
        string $name
    )
    {
        if (!$this->validateValues($id, $code, $name)) {
            throw new ArgumentException(Loc::getMessage("ROBOT_CORE_ARGUMENT_EXCEPTION"));
        }

        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param int $id
     * @param string $code
     * @param string $name
     * @return bool
     */
    protected function validateValues(
        int $id,
        string $code,
        string $name
    ): bool
    {
        return !empty($id) && !empty($code) && !empty($name);
    }
}