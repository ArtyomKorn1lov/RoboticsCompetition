<?php

namespace Robot\Core\Cache;

interface ICacheService
{
    /**
     * @param string $cacheKey
     * @param string $initDir
     * @param int $ttl
     * @param array $cacheParams
     * @return bool
     */
    public function init(string $cacheKey, string $initDir, int $ttl, array $cacheParams): bool;

    /**
     * @return mixed
     */
    public function getData(): mixed;

    /**
     * @return bool
     */
    public function start(): bool;

    /**
     * @param mixed $data
     * @return void
     */
    public function end(mixed $data): void;

    /**
     * @return void
     */
    public function abort(): void;

    /**
     * @param string $path
     * @return void
     */
    public function startTag(string $path): void;

    /**
     * @return void
     */
    public function endTag(): void;

    /**
     * @param string $tagName
     * @return void
     */
    public function registerTag(string $tagName): void;

    /**
     * @return void
     */
    public function abortTag(): void;

    /**
     * @param string $tagName
     * @return void
     */
    public function clearTag(string $tagName): void;
}