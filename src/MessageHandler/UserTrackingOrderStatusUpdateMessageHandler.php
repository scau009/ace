<?php

namespace App\MessageHandler;

use App\Message\UserTrackingOrderStatusUpdateMessage;
use Barry\DeferredLoggerBundle\Service\DeferredLogger;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UserTrackingOrderStatusUpdateMessageHandler
{
    public function __invoke(UserTrackingOrderStatusUpdateMessage $message): void
    {
        // do something with your message
        DeferredLogger::contextInfo("Order {$message->orderNo} status updated from {$message->oldStatus->value} to {$message->newStatus->value}");
        //todo 
    }
}
