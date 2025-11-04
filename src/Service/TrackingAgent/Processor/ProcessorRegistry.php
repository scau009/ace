<?php

namespace App\Service\TrackingAgent\Processor;

use App\Service\TrackingAgent\Model\TrackingResult;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProcessorRegistry
{
    /** @var IProcessor[] */
    private array $processors = [];

    public function __construct(iterable $processors = [])
    {
        $this->processors = $processors instanceof \Traversable ? iterator_to_array($processors) : $processors;
    }

    public function addProcessor(IProcessor $processor): void
    {
        $this->processors[] = $processor;
    }

    public function process(IOriginData $originData): ?TrackingResult
    {
        foreach ($this->processors as $processor) {
            if ($processor->supports($originData)) {
                return $processor->process($originData);
            }
        }
        throw new BadRequestException("No processor found for origin data:" . $originData->getTrackingNumber());
    }
}
