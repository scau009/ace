<?php

namespace App\Service\TrackingAgent\Agent\TrackingMore;

use App\Repository\TrackingMoreResultsRepository;
use App\Service\TrackingAgent\Agent\TrackingMore\Dto\Courier;
use App\Service\TrackingAgent\Model\TrackingResult;
use App\Service\TrackingAgent\Processor\ProcessorRegistry;
use App\Service\TrackingAgent\TrackingAgent;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use TrackingMore\Couriers;
use TrackingMore\Trackings;

class Agent implements TrackingAgent
{
    public function __construct(private readonly string                                    $apiKey,
                                private readonly LoggerInterface                           $trackingAgentLogger,
                                private readonly CacheInterface                            $trackingMorePool,
                                private readonly DenormalizerInterface&NormalizerInterface $serializer,
                                private readonly TrackingMoreResultsRepository             $trackingMoreResultsRepository,
                                private readonly ProcessorRegistry $processorRegistry)
    {

    }

    public function register(string $trackingNo, string $carrierCode = ''): void
    {
        $this->trackingAgentLogger->info("Register TrackingMore tracking number: {$trackingNo} with carrier code: {$carrierCode}");
        if (empty($carrierCode)) {
            $carrierCode = $this->detectCourierCode($trackingNo);
            if (empty($carrierCode)) {
                $this->trackingAgentLogger->error("TrackingMore detect courier code failed: {$trackingNo}");
                return;
            }
        } else {
            $courier = $this->findCourier($carrierCode);
            if (!$courier) {
                $this->trackingAgentLogger->error("TrackingMore carrier code: {$carrierCode} not found");
                return;
            }
        }
        try {
            $response = (new Trackings($this->apiKey))->createTracking([
                'tracking_number' => $trackingNo,
                'courier_code' => $carrierCode,
            ]);
            //todo 转换，存储
            $this->trackingAgentLogger->info("aa", $response);
            return;
        } catch (\Exception $exception) {
            $this->trackingAgentLogger->error("TrackingMore register tracking number failed: {$exception->getMessage()}", [
                'apiKey' => $this->apiKey,
                'trackingNo' => $trackingNo,
                'carrierCode' => $carrierCode,
                'exception' => $exception,
            ]);
            return;
        }
    }

    public function getTracking(string $trackingNo): ?TrackingResult
    {
        try {
            $response = (new Trackings($this->apiKey))->getTrackingResults([
                'tracking_numbers' => $trackingNo,
            ]);
            $trackingResult = $response['data'][0] ?? [];
            $record = $this->trackingMoreResultsRepository->createOrUpdateOne($trackingResult['tracking_number'], $trackingResult['courier_code'], $trackingResult);
            return $this->processorRegistry->process($record);
        } catch (\Exception $exception) {
            $this->trackingAgentLogger->error("TrackingMore get tracking number failed: {$exception->getMessage()}", [
                'apiKey' => $this->apiKey,
                'trackingNo' => $trackingNo,
                'exception' => $exception,
            ]);
            return null;
        }
    }

    public function batchGetTracking(array $trackingNos): array
    {
        // TODO: Implement batchGetTracking() method.
        return [];
    }

    private function findCourier(string $carrierCode): ?Courier
    {
        $courierList = $this->getAllCouriers();
        foreach ($courierList as $courier) {
            if ($courier->getCourierCode() === $carrierCode) {
                return $courier;
            }
        }
        return null;
    }

    private function detectCourierCode(string $trackingNo): ?string
    {
        try {
            $response = (new Couriers($this->apiKey))->detect([
                'tracking_number' => $trackingNo,
            ]);
            $courierCode = $response['data'][0]['courier_code'] ?? '';
            return $courierCode;
        } catch (\Exception $exception) {
            $this->trackingAgentLogger->error("TrackingMore detect courier code failed: {$exception->getMessage()}", [
                'apiKey' => $this->apiKey,
                'trackingNo' => $trackingNo,
                'exception' => $exception,
            ]);
            return null;
        }
    }

    /**
     * @return Courier[]
     * @throws InvalidArgumentException
     */
    public function getAllCouriers(): array
    {
        return $this->trackingMorePool->get('allCouriers', function (ItemInterface $item): array {
            try {
                $item->expiresAfter(60 * 5);
                $response = (new Couriers($this->apiKey))->getAllCouriers();
                $rawData = $response['data'] ?? [];
                foreach ($rawData as $courierArr) {
                    $courierList[] = $this->serializer->denormalize($courierArr, Courier::class);
                }
                return $courierList ?? [];
            } catch (\Exception $exception) {
                $this->trackingAgentLogger->error("Get TrackingMore countries failed: {$exception->getMessage()}", [
                    'apiKey' => $this->apiKey,
                    'exception' => $exception,
                ]);
                return [];
            }
        });
    }
}
