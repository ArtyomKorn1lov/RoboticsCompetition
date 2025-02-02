<?php

namespace Robot\Core\Tools\IBlocks;

interface IHelper
{
    public static function getIblock(string $code): int|bool;
}