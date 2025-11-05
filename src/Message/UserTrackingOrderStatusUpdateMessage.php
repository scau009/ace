<?php

namespace App\Message;

use App\Enum\UserTrackingOrderStatusEnum;

final class UserTrackingOrderStatusUpdateMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

    // public function __construct(
    //     public readonly string $name,
    // ) {
    // }
    public function __construct(
        public readonly string $orderNo,
        public readonly UserTrackingOrderStatusEnum $oldStatus,
        public readonly UserTrackingOrderStatusEnum $newStatus,
    ) {
    }
}
