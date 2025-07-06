<?php

namespace Robot\Core\DTO\Include;

final class File
{
    /**
     * @param bool $fileFound
     * @param string $fileName
     * @param string $filePath
     * @param string $filePathTMP
     * @param string|null $physicalPath
     */
    public function __construct(
        public bool $fileFound,
        public string $fileName,
        public string $filePath,
        public string $filePathTMP,
        public ?string $physicalPath = null,
    )
    {
    }
}