<?php

namespace App\Repository;

use App\Entity\TrackingMoreResults;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrackingMoreResultsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrackingMoreResults::class);
    }

    public function createOrUpdateOne(string $trackingNumber, string $carrierCode, array $data)
    {
        $document = $this->findOneBy([
            'trackingNumber' => $trackingNumber,
            'carrierCode' => $carrierCode,
        ]);
        if (!$document) {
            $document = new TrackingMoreResults();
            $document->setTrackingNumber($trackingNumber);
            $document->setCarrierCode($carrierCode);
            $document->setCreatedAt(new \DateTimeImmutable());
        }
        $document->setResult($data);
        $document->setUpdatedAt(new \DateTimeImmutable());
        $this->getEntityManager()->persist($document);
        $this->getEntityManager()->flush();
        return $document;
    }
}
