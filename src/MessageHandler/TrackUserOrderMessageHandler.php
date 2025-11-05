<?php

namespace App\MessageHandler;

use App\Enum\LockKeyPrefixEnum;
use App\Message\TrackUserOrderMessage;
use App\Repository\UserTrackingOrderRepository;
use App\Service\TrackingService\TrackingService;
use Barry\DeferredLoggerBundle\Service\DeferredLogger;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class TrackUserOrderMessageHandler
{
    public function __construct(private readonly UserTrackingOrderRepository $userTrackingOrderRepository,
                                private readonly TrackingService             $trackingService,
                                private readonly LockFactory                 $lockFactory)
    {
    }

    public function __invoke(TrackUserOrderMessage $message): void
    {
        // do something with your message
        $orderNo = $message->orderNo;

        try {
            // 争抢锁，避免重复处理
            $lockKey = LockKeyPrefixEnum::TrackUserOrder->value . $orderNo;
            $lock = $this->lockFactory->createLock($lockKey);
            if (!$lock->acquire(true)) {
                DeferredLogger::contextInfo("Order {$orderNo} is being processed by another worker");
                return;
            }

            $userTrackingOrder = $this->userTrackingOrderRepository->find($orderNo);
            if (!$userTrackingOrder) {
                DeferredLogger::contextInfo("Order {$orderNo} not found");
                return;
            }
            $this->trackingService->trackOrder($userTrackingOrder);
        } catch (\Exception $exception) {
            DeferredLogger::contextException($exception);
        } finally {
            if (isset($lock) && $lock) {
                $lock->release();
            }
        }
    }
}
