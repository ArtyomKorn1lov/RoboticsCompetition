<?php

namespace Robot\Core\Tools\Files;

interface IHelper
{
    /**
     * @param int $id
     * @return string|bool
     */
    public function getFilePath(int $id): string|bool;

    /**
     * @param array $fileValues
     * @param int $index
     * @return string|bool
     */
    public function getFilePreviewByIndex(array $fileValues, int $index): string|bool;

    /**
     * @param string $url
     * @return string|bool
     */
    public function getEmbedVideo(string $url): string|bool;
}