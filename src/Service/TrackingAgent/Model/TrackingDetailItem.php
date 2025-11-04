<?php

namespace App\Service\TrackingAgent\Model;

class TrackingDetailItem
{
    public string $content = '';

    public \DateTime $time;
    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): TrackingDetailItem
    {
        $this->content = $content;
        return $this;
    }

    public function getTime(): \DateTime
    {
        return $this->time;
    }

    public function setTime(\DateTime $time): TrackingDetailItem
    {
        $this->time = $time;
        return $this;
    }
}
