<?php

namespace App\Message;

final class FooMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

    // public function __construct(
    //     public readonly string $name,
    // ) {
    // }
    public function __construct(public readonly string $orderNo)
    {
    }
}
