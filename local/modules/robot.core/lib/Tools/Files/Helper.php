<?php

namespace Robot\Core\Tools\Files;

use Bitrix\Main\Localization\Loc;
use CFile;

Loc::loadMessages(__FILE__);

class Helper
{
    /**
     * @param int $id
     * @return string|bool
     */
    public function getFilePath(int $id): string|bool
    {
        if (empty($id)) {
            return false;
        }
        $path = CFile::GetPath($id);
        if (empty($path)) {
            return false;
        }
        return $path;
    }
}