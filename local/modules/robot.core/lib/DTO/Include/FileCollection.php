<?php

namespace Robot\Core\DTO\Include;

class FileCollection
{
    /** @var File[] массив файлов */
    private array $items;

    /**
     * @param File[] $items
     */
    public function __construct(array $items = [])
    {
        if (empty($items)) {
            $this->items = [];
            return;
        }
        $this->items = array_map(function ($item) {
            return new File(
                fileFound: $item->fileFound,
                fileName: $item->fileName,
                filePath: $item->filePath,
                filePathTMP: $item->filePathTMP
            );
        }, $items);
    }

    /**
     * @param File $file
     * @return void
     */
    public function add(File $file): void
    {
        $this->items[] = $file;
    }

    /**
     * @param File $file
     * @param int $index
     * @return void
     */
    public function update(File $file, int $index): void
    {
        $this->items[$index] = $file;
    }

    /**
     * @param int $index
     * @return File
     */
    public function get(int $index): File
    {
        return $this->items[$index];
    }

    /**
     * @return array|File[]
     */
    public function getAll(): array
    {
        return $this->items;
    }
}