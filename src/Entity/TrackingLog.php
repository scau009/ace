<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[Entity]
#[Table(name: '`tracking_log`')]
#[Index(name: 'idx_orderNo', columns: ['order_no'])]
class TrackingLog
{
    #[Id]
    #[Column(type: 'string', unique: true)]
    #[GeneratedValue(strategy: 'AUTO')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private string $id = '';

    #[Column(type: 'string', nullable: false)]
    private string $orderNo = '';

    #[Column(type: 'string', nullable: false)]
    private string $carrierCode = '';

    #[Column(type: 'string', nullable: false)]
    private string $trackingNumber = '';

    #[Column(type: 'json',nullable: false)]
    private array $result = [];

    #[Column(type: 'date_immutable',nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): TrackingLog
    {
        $this->id = $id;
        return $this;
    }

    public function getOrderNo(): string
    {
        return $this->orderNo;
    }

    public function setOrderNo(string $orderNo): TrackingLog
    {
        $this->orderNo = $orderNo;
        return $this;
    }

    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    public function setCarrierCode(string $carrierCode): TrackingLog
    {
        $this->carrierCode = $carrierCode;
        return $this;
    }

    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(string $trackingNumber): TrackingLog
    {
        $this->trackingNumber = $trackingNumber;
        return $this;
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function setResult(array $result): TrackingLog
    {
        $this->result = $result;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): TrackingLog
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
