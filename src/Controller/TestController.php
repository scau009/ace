<?php

namespace App\Controller;

use App\Repository\Common\UserRepository;
use Barry\DeferredLoggerBundle\Service\DeferredLogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(UserRepository $repository): Response
    {
        DeferredLogger::contextInfo("test");
        DeferredLogger::contextData([
            'foo' => [
                'bar' => 'baz'
            ],
        ]);
        $users = $repository->findAll();
        DeferredLogger::contextData([
            'users' => $users,
        ]);

        return $this->json([
            'message' => 'Hello World!',
            'users' => $users,
        ]);
    }
}
