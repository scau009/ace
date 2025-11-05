<?php

namespace App\Service\TrackingOrderService;

use App\Entity\UserTrackingOrder;
use App\Repository\UserTrackingOrderRepository;
use App\Service\TrackingOrderService\Dto\CreateTrackingOrderDto;

class TrackingOrderService
{
    public function __construct(
        private readonly UserTrackingOrderRepository $userTrackingOrderRepository,
    ) {
    }

    /**
     * @param CreateTrackingOrderDto $req
     * @return UserTrackingOrder|null
     * @throws \Exception
     */
    public function createTrackingOrder(CreateTrackingOrderDto $req): ?UserTrackingOrder
    {
        // 1. 校验参数
        if (empty($req->getUserId())) {
            throw new \InvalidArgumentException('用户ID不能为空');
        }

        if (empty($req->getTrackingNumber())) {
            throw new \InvalidArgumentException('跟踪号码不能为空');
        }

        if (empty($req->getCarrierCode())) {
            throw new \InvalidArgumentException('承运商代码不能为空');
        }

        if (empty($req->getCarrierName())) {
            throw new \InvalidArgumentException('承运商名称不能为空');
        }

        // 2. 存储客户的跟踪订单
        $now = new \DateTimeImmutable();
        $orderData = [
            'userId' => $req->getUserId(),
            'carrierCode' => $req->getCarrierCode(),
            'carrierName' => $req->getCarrierName(),
            'trackingNumber' => $req->getTrackingNumber(),
            'createdAt' => $now,
            'updatedAt' => $now,
        ];

        $trackingOrder = $this->userTrackingOrderRepository->createOne($orderData);

        // 保存到数据库
        $this->userTrackingOrderRepository->getEntityManager()->flush();

        // 3. 触发异步任务执行首次跟踪
        if ($req->isAsyncTrack()) {

        }

        // 4. 返回跟踪订单
        return $trackingOrder;
    }
}
