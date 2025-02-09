<?php

namespace Robot\Core\Tools\IBlocks;

interface IHelper
{
    /**
     * @param string $code
     * @return int|bool
     */
    public static function getIblock(string $code): int|bool;
}