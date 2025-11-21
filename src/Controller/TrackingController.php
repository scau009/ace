<?php

namespace App\Controller;

use App\Entity\Common\User;
use App\Repository\UserTrackingOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class TrackingController extends AbstractController
{
    public function __construct(
        private readonly UserTrackingOrderRepository $trackingOrderRepository,
    ) {
    }

    #[Route('/tracking/search', name: 'app_tracking_search', methods: ['POST'])]
    public function search(Request $request): Response
    {
        // Validate CSRF token
        $submittedToken = $request->request->get('_csrf_token');
        if (!$this->isCsrfTokenValid('tracking_search', $submittedToken)) {
            $this->addFlash('error', 'Invalid security token. Please try again.');
            return $this->redirectToRoute('app_home');
        }

        $trackingNumber = trim($request->request->get('tracking_number', ''));

        if (empty($trackingNumber)) {
            $this->addFlash('error', 'Please enter a tracking number.');
            return $this->redirectToRoute('app_home');
        }

        /** @var User $user */
        $user = $this->getUser();

        // Search for existing tracking order for this user
        $trackingOrder = $this->trackingOrderRepository->findOneBy([
            'userId' => $user->getId(),
            'trackingNumber' => $trackingNumber,
        ]);

        if ($trackingOrder) {
            // Order exists, redirect to order detail page
            return $this->redirectToRoute('app_tracking_detail', [
                'orderNo' => $trackingOrder->getOrderNo(),
            ]);
        }

        // Order doesn't exist, redirect to create tracking order page
        return $this->redirectToRoute('app_tracking_create', [
            'tracking_number' => $trackingNumber,
        ]);
    }

    #[Route('/tracking/order/{orderNo}', name: 'app_tracking_detail', methods: ['GET'])]
    public function detail(string $orderNo): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Find the tracking order
        $trackingOrder = $this->trackingOrderRepository->findOneBy([
            'orderNo' => $orderNo,
            'userId' => $user->getId(),
        ]);

        if (!$trackingOrder) {
            $this->addFlash('error', 'Tracking order not found.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('tracking/detail.html.twig', [
            'order' => $trackingOrder,
        ]);
    }

    #[Route('/tracking/create', name: 'app_tracking_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $trackingNumber = $request->query->get('tracking_number', '');

        if ($request->isMethod('POST')) {
            // Handle form submission
            $submittedToken = $request->request->get('_csrf_token');
            if (!$this->isCsrfTokenValid('tracking_create', $submittedToken)) {
                $this->addFlash('error', 'Invalid security token. Please try again.');
                return $this->redirectToRoute('app_tracking_create', [
                    'tracking_number' => $trackingNumber,
                ]);
            }

            // TODO: Implement order creation logic
            // This will be implemented based on your TrackingOrderService

            $this->addFlash('success', 'Tracking order created successfully!');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('tracking/create.html.twig', [
            'tracking_number' => $trackingNumber,
        ]);
    }
}