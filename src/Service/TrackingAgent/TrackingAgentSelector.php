<?php

namespace App\Service\TrackingAgent;

use App\Service\TrackingAgent\Processor\IProcessor;

class TrackingAgentSelector
{

    /** @var TrackingAgent[] */
    private array $agents = [];

    public function __construct(iterable $agents = [])
    {
        $this->agents = $agents instanceof \Traversable ? iterator_to_array($agents) : $agents;
    }

    public function getAllAgents(): array
    {
        return $this->agents;
    }
}
