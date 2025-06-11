<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum TaskStatus: string
{
    use Values;

    case TODO = 'to-do';
    case IN_PROGRESS = 'in progress';
    case DONE = 'done';
}
