<?php

namespace App\MessageHandler;

use App\Message\FooMessage;
use Barry\DeferredLoggerBundle\Service\DeferredLogger;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class FooMessageHandler
{
    public function __invoke(FooMessage $message): void
    {
        DeferredLogger::contextInfo("FooMessage {$message->orderNo} handled");
    }
}
