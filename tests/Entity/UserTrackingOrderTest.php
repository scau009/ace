<?php

namespace App\Tests\Entity;

use App\Entity\UserTrackingOrder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTrackingOrderTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testCreate()
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $userTrackingOrder = new UserTrackingOrder();
        $userTrackingOrder->setUserId(1);
        $userTrackingOrder->setAgentCode('123456');
        $userTrackingOrder->setCarrierCode('123456');
        $userTrackingOrder->setCarrierName('123456');
        $userTrackingOrder->setTrackingNumber('123456');
        $userTrackingOrder->setStatus(0);
        $userTrackingOrder->setCreatedAt(new \DateTimeImmutable());
        $userTrackingOrder->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->persist($userTrackingOrder);
        $entityManager->flush();
        $this->assertNotEmpty($userTrackingOrder->getOrderNo());
    }
}
