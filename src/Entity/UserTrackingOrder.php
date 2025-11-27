<?php

namespace App\Entity;

use App\Enum\UserTrackingOrderStatusEnum;
use App\IdGenerator\UserTrackingOrderIdGenerator;
use App\Repository\UserTrackingOrderRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[Entity(repositoryClass: UserTrackingOrderRepository::class)]
#[Index(name: 'idx_user_tracking_orders_user_id',fields: ['user_id','status'])]
#[Table(name: '`user_tracking_order`')]
class UserTrackingOrder
{
    #[Id]
    #[Column(type: 'string', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UserTrackingOrderIdGenerator::class)]
    private string $orderNo = '';

    #[Column(type: 'integer', nullable: false)]
    private int $userId = 0;

    /**
     * @var string 代理编号
     */
    #[Column(type: 'string', nullable: false)]
    private string $agentCode = '';

    /**
     * @var string 代理订单号
     */
    #[Column(type: 'string', nullable: false)]
    private string $agentOrderNo = '';

    #[Column(type: 'string', nullable: false)]
    private string $carrierCode = '';

    #[Column(type: 'string', nullable: false)]
    private string $carrierName = '';

    #[Column(type: 'string', nullable: false)]
    private string $trackingNumber = '';

    #[Column(type: 'integer', nullable: false)]
    private int $status = 0;

    #[Column(type: 'datetime_immutable', nullable: false)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s\Z'])]
    private \DateTimeImmutable $createdAt;

    #[Column(type: 'datetime_immutable', nullable: false)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s\Z'])]
    private \DateTimeImmutable $updatedAt;

    /**
     * @var \DateTimeImmutable|null 最后一次跟踪时间
     */
    #[Column(type: 'datetime_immutable', nullable: true)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s\Z'])]
    private ?\DateTimeImmutable $lastTrackedAt = null;

    public function isFinished(): bool
    {
        return in_array($this->status, UserTrackingOrderStatusEnum::finished());
    }

    public function getOrderNo(): string
    {
        return $this->orderNo;
    }

    public function setOrderNo(string $orderNo): UserTrackingOrder
    {
        $this->orderNo = $orderNo;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): UserTrackingOrder
    {
        $this->userId = $userId;
        return $this;
    }

    public function getAgentCode(): string
    {
        return $this->agentCode;
    }

    public function setAgentCode(string $agentCode): UserTrackingOrder
    {
        $this->agentCode = $agentCode;
        return $this;
    }

    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    public function setCarrierCode(string $carrierCode): UserTrackingOrder
    {
        $this->carrierCode = $carrierCode;
        return $this;
    }

    public function getCarrierName(): string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): UserTrackingOrder
    {
        $this->carrierName = $carrierName;
        return $this;
    }

    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(string $trackingNumber): UserTrackingOrder
    {
        $this->trackingNumber = $trackingNumber;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): UserTrackingOrder
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): UserTrackingOrder
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): UserTrackingOrder
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getLastTrackedAt(): ?\DateTimeImmutable
    {
        return $this->lastTrackedAt;
    }

    public function setLastTrackedAt(?\DateTimeImmutable $lastTrackedAt): UserTrackingOrder
    {
        $this->lastTrackedAt = $lastTrackedAt;
        return $this;
    }

    public function getAgentOrderNo(): string
    {
        return $this->agentOrderNo;
    }

    public function setAgentOrderNo(string $agentOrderNo): UserTrackingOrder
    {
        $this->agentOrderNo = $agentOrderNo;
        return $this;
    }
}
