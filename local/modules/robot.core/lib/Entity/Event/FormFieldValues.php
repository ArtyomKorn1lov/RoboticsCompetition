<?php

namespace Robot\Core\Entity\Event;

use Bitrix\Main\ArgumentException;

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
            throw new ArgumentException("Неверные значения входных параметров");
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
        return  $this->code;
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