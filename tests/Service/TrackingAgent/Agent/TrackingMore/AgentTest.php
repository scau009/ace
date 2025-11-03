<?php

namespace App\Tests\Service\TrackingAgent\Agent\TrackingMore;

use App\Service\TrackingAgent\Agent\TrackingMore\Agent;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AgentTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testGetAllCouriers()
    {
        $agent = self::getContainer()->get(Agent::class);
        $courierList = $agent->getAllCouriers();
        $this->assertNotEmpty($courierList);
    }

    public function testMongoDBConnection()
    {
        $dm = self::getContainer()->get('doctrine_mongodb.odm.default_document_manager');
        $this->assertNotNull($dm);
    }
}
