<?php

namespace Robot\Core\Cache;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Application;
use Bitrix\Main\Data\TaggedCache;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

class CacheService implements ICacheService
{
    /** @var int время жизни кэша */
    private const CACHE_TTL = 3600;
    private const MODULE_CACHE_PATH = 'robot.core/';
    /** @var int путь к папке кэша */
    private const DEFAULT_CACHE_PATH = 'cache';
    /** @var int код кэша модуля */
    private const DEFAULT_CACHE_KEY = 'robot_core_cache_key';

    /** @var Cache служба кэширования */
    protected Cache $cache;
    /** @var TaggedCache служба пометки кеша тегами */
    protected TaggedCache $taggedCache;

    public function __construct()
    {
        $this->cache = Cache::createInstance();
        $this->taggedCache = Application::getInstance()->getTaggedCache();
    }

    /**
     * @param int $ttl
     * @param string $cacheKey
     * @param string $initDir
     * @return bool
     */
    public function init(string $cacheKey = self::DEFAULT_CACHE_KEY, string $initDir = self::DEFAULT_CACHE_PATH, int $ttl = self::CACHE_TTL): bool
    {
        return $this->cache->initCache($ttl, $cacheKey, self::MODULE_CACHE_PATH . $initDir);
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->cache->getVars();
    }

    /**
     * @return bool
     */
    public function start(): bool
    {
        return $this->cache->startDataCache();
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function end(mixed $data): void
    {
        $this->cache->endDataCache($data);
    }

    /**
     * @return void
     */
    public function abort(): void
    {
        $this->cache->abortDataCache();
    }

    public function startTag(string $path): void
    {
        $this->taggedCache->startTagCache($path);
    }

    /**
     * @return void
     * @throws ArgumentException
     * @throws SystemException
     */
    public function endTag(): void
    {
        $this->taggedCache->endTagCache();
    }

    /**
     * @param string $tagName
     * @return void
     */
    public function registerTag(string $tagName): void
    {
        $this->taggedCache->registerTag($tagName);
    }

    /**
     * @return void
     */
    public function abortTag(): void
    {
        $this->taggedCache->abortTagCache();
    }

    /**
     * @param string $tagName
     * @return void
     * @throws ArgumentException
     * @throws SystemException
     * @throws ObjectPropertyException
     */
    public function clearTag(string $tagName): void
    {
        $this->taggedCache->clearByTag($tagName);
    }
}