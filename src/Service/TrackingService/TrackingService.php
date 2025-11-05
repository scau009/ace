<?php

namespace App\Service\TrackingService;

use App\Entity\UserTrackingOrder;
use App\Enum\TrackingAgentEnum;
use App\Enum\UserTrackingOrderStatusEnum;
use App\Message\UserTrackingOrderStatusUpdateMessage;
use App\Service\TrackingAgent\Model\TrackingResult;
use App\Service\TrackingAgent\TrackingAgent;
use Barry\DeferredLoggerBundle\Service\DeferredLogger;
use Symfony\Component\Messenger\MessageBusInterface;

class TrackingService
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    /**
     * @throws \Exception
     */
    public function trackOrder(UserTrackingOrder $userTrackingOrder): void
    {
        $defferJobs = [];
        if ($userTrackingOrder->isFinished()) {
            DeferredLogger::contextInfo("Order {$userTrackingOrder->getOrderNo()} already finished");
            return;
        }

        if (empty($userTrackingOrder->getAgentCode())) {
            $agent = $this->selectAgent($userTrackingOrder);
            if (!$agent) {
                throw new \Exception("{$userTrackingOrder->getOrderNo()} not match any agent");
            }
            $userTrackingOrder->setAgentCode($agent->getCode());
        } else {
            $agentClass = TrackingAgentEnum::from($userTrackingOrder->getAgentOrderNo())->getAgentClass();
            if (!$agentClass) {
                throw new \Exception("{$userTrackingOrder->getOrderNo()} not match any agent");
            }
            $agent = new $agentClass();
        }

        if (empty($userTrackingOrder->getAgentOrderNo())) {
            $agentOrderNo = $agent->register($userTrackingOrder->getTrackingNumber(), $userTrackingOrder->getCarrierCode());
            if (empty($agentOrderNo)) {
                throw new \Exception("{$userTrackingOrder->getOrderNo()} register failed");
            }
            $userTrackingOrder->setAgentOrderNo($agentOrderNo);
        }

        $trackingResult = $agent->getTracking($userTrackingOrder->getTrackingNumber());
        if (!$trackingResult) {
            throw new \Exception("{$userTrackingOrder->getOrderNo()} track failed");
        }
        $newStatus = $this->mappingStatus($trackingResult)->value;
        if ($newStatus != $userTrackingOrder->getStatus()) {
            $oldStatus = $userTrackingOrder->getStatus();
            $userTrackingOrder->setStatus($newStatus);
            $defferJobs[] = new UserTrackingOrderStatusUpdateMessage($userTrackingOrder->getOrderNo(), UserTrackingOrderStatusEnum::from($oldStatus), UserTrackingOrderStatusEnum::from($newStatus));
        }

        if (!empty($defferJobs)) {
            foreach ($defferJobs as $defferJob) {
                $this->messageBus->dispatch($defferJob);
            }
        }
    }

    private function selectAgent(UserTrackingOrder $order): ?TrackingAgent
    {
        //todo 根据特定规则（待定）选择对应的TackingAgent
    }

    private function mappingStatus(TrackingResult $trackingResult): UserTrackingOrderStatusEnum
    {
       // todo 状态映射
    }


}
