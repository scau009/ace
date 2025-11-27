<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[Entity(repositoryClass: CarrierRepository::class)]
#[Table(name: '`carrier`')]
class Carrier
{
    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(type: 'string')]
    private string $carrierCode = '';

    #[Column(type: 'string')]
    private string $carrierType = '';

    /**
     * @var string 承运商名称
     */
    #[Column(type: 'string')]
    private string $carrierName = '';

    #[Column(name: 'description', type: 'string')]
    private string $desc = '';

    #[Column(type: 'string')]
    private string $logo = '';

    #[Column(type: 'integer', nullable: false)]
    private int $status = 0;

    #[Column(type: 'datetime_immutable', nullable: false)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s\Z'])]
    private \DateTimeImmutable $createdAt;

    #[Column(type: 'datetime_immutable', nullable: false)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s\Z'])]
    private \DateTimeImmutable $updatedAt;

    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    public function setCarrierCode(string $carrierCode): Carrier
    {
        $this->carrierCode = $carrierCode;
        return $this;
    }

    public function getCarrierName(): string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): Carrier
    {
        $this->carrierName = $carrierName;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): Carrier
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): Carrier
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): Carrier
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getCarrierType(): string
    {
        return $this->carrierType;
    }

    public function setCarrierType(string $carrierType): Carrier
    {
        $this->carrierType = $carrierType;
        return $this;
    }

    public function getDesc(): string
    {
        return $this->desc;
    }

    public function setDesc(string $desc): Carrier
    {
        $this->desc = $desc;
        return $this;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): Carrier
    {
        $this->logo = $logo;
        return $this;
    }
}
