<?php

namespace App\Service\TrackingAgent\Agent\OneSevenTracking;

use App\Service\TrackingAgent\Model\TrackingResult;
use App\Service\TrackingAgent\TrackingAgent;
use Barry\DeferredLoggerBundle\Service\DeferredLogger;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Agent implements TrackingAgent
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    public function register(string $trackingNo, string $carrierCode): void
    {
        // TODO: Implement register() method.
    }

    public function getTracking(string $trackingNo): ?TrackingResult
    {

    }

    public function batchGetTracking(array $trackingNos): array
    {
        // TODO: Implement batchGetTracking() method.
    }

    public function getAllCarriers(): array
    {
        $response =$this->client->request('GET', 'https://res.17track.net/asset/carrier/info/apicarrier.all.json');
        $content = $response->getContent();
        return json_decode($content, true);
    }
}
