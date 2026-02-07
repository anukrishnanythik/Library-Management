<?php

namespace App\Enums;

enum ReservationStatus: int
{
    case ACTIVE   = 1;
    case RETURNED = 2;
    case OVERDUE  = 3;
}


