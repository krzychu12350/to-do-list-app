<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum TaskPriority: string
{
    use Values;

    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}


