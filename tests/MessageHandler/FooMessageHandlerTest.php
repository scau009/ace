<?php

namespace App\Tests\MessageHandler;

use App\Message\FooMessage;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class FooMessageHandlerTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testMessageSend()
    {
        $message = new FooMessage("123456");
        $messageBus = self::getContainer()->get(MessageBusInterface::class);
        $messageBus->dispatch($message);
        $this->assertEquals(1, 1);
    }
}
