<?php

namespace Robot\Core\Tools\Events;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Entity\Event;
use Bitrix\Main\SystemException;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\Cache\ICacheService;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Constants;

class HighloadBlocksEventHandler
{
    /**
     * @param Event $event
     * @return void
     */
    public static function onAfterChange(Event $event): void
    {
        $logger = LoggerFactory::build();
        try {
            $cacheService = ServiceLocator::getInstance()->get(ICacheService::class);
            $cacheService->clearTag(Constants::REGISTRATION_FIELD_TAG_CACHE);
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            $logger->error($exception);
        }
    }
}