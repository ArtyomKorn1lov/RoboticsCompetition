<?php

namespace Robot\Core\Logger;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

use Exception;

class Logger implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param Exception $exception
     * @return void
     */
    public function error(Exception $exception): void
    {
        $this->logger->error(
            "{date} - {host}\nModule name: robot.core\nMessage: {exception}\n{trace}\n{delimiter}\n\n",
            [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]
        );
    }
}