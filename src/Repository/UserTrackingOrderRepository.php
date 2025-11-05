<?php

namespace App\Repository;

use App\Entity\UserTrackingOrder;
use App\Enum\UserTrackingOrderStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EntityManagerInterface getEntityManager()
 * @method UserTrackingOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTrackingOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTrackingOrder[] findAll()
 * @method UserTrackingOrder[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTrackingOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTrackingOrder::class);
    }

    public function createOne(array $data): UserTrackingOrder
    {
        $entity = new UserTrackingOrder();
        $entity->setOrderNo($data['orderNo']);
        $entity->setUserId($data['userId']);
        $entity->setAgentCode($data['agentCode']);
        $entity->setCarrierCode($data['carrierCode']);
        $entity->setCarrierName($data['carrierName']);
        $entity->setStatus(UserTrackingOrderStatusEnum::Pending->value);
        $entity->setCreatedAt($data['createdAt']);
        $entity->setUpdatedAt($data['updatedAt']);
        $entity->setTrackingNumber($data['trackingNumber']);
        $this->getEntityManager()->persist($entity);
        return $entity;
    }
}
