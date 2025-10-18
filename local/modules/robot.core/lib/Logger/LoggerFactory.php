<?php

namespace Robot\Core\Logger;

use Bitrix\Main\Diag\LogFormatter;
use Bitrix\Main\Diag\FileLogger;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Type\DateTime;

use Psr\Log\LogLevel;

final class LoggerFactory
{
    /** @var string относительный путь к папке с логами */
    private const LOG_DIR = __DIR__ . "/../../logs/";

    /**
     * @return Logger
     */
    public static function build(): Logger
    {
        if (!Directory::isDirectoryExists(self::LOG_DIR)) {
            Directory::createDirectory(self::LOG_DIR);
        }

        $formatter = new LogFormatter(true);

        $object = new Logger();
        $logger = new FileLogger(self::LOG_DIR . (new DateTime())->format('Y-m-d') . '.log');
        $logger->setLevel(LogLevel::ERROR);
        $logger->setFormatter($formatter);
        $object->setLogger($logger);
        return $object;
    }
}