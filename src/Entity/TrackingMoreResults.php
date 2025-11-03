<?php

namespace App\Entity;

use App\Repository\TrackingMoreResultsRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[Entity(repositoryClass: TrackingMoreResultsRepository::class)]
#[Table(name: '`tracking_more_results`')]
#[Index(name: 'idx_trackingNumber_carrierCode', columns: ['tracking_number', 'carrier_code'])]
class TrackingMoreResults
{
    #[Id]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    #[Column(unique: true)]
    private ?string $id = null;

    #[Column(type: 'string', length: 255, nullable: false)]
    private string $trackingNumber = '';

    #[Column(type: 'string', length: 255, nullable: false)]
    private string $carrierCode = '';

    #[Column(type: 'json',nullable: false)]
    private array $result = [];

    #[Column(type: 'date_immutable',nullable: false)]
    private \DateTimeImmutable $createdAt;

    #[Column(type: 'date_immutable',nullable: false)]
    private \DateTimeImmutable $updatedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(string $trackingNumber): void
    {
        $this->trackingNumber = $trackingNumber;
    }

    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    public function setCarrierCode(string $carrierCode): void
    {
        $this->carrierCode = $carrierCode;
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function setResult(array $result): void
    {
        $this->result = $result;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
