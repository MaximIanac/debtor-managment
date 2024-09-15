<?php

namespace App\Enums;

enum PaymentType: string
{
    case Increase = 'increase';
    case Decrease = 'decrease';
    case PaidOff = 'paid';
}
