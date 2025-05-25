<?php

namespace Robot\Core\Tools\IBlocks;

interface IHelper
{
    /**
     * @param string $code
     * @return int|bool
     */
    public static function getIBlock(string $code): int|bool;
}