<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case ACTIVE   = 'active';
    case RETURNED = 'returned';
    case OVERDUE  = 'overdue';
}


