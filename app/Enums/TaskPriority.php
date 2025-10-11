<?php

namespace App\Enums;

enum TaskPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public function label() {
        return match($this) {
            TaskPriority::LOW => 'Basse',
            TaskPriority::MEDIUM => 'Moyenne',
            TaskPriority::HIGH => 'Elever',
        };
    }
}
