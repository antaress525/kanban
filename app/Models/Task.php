<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order',
        'status',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
        ];
    }

    protected static function booted()
    {
        static::creating(function ($task) {
            if (!$task->order) {
                $maxOrder = Task::where('kanban_id', $task->kanban_id)
                    ->where('status', $task->status)
                    ->max('order');

                $task->order = $maxOrder ? $maxOrder + 1 : 1;
            }
        });
    }

    public function kanban():BelongsTo
    {
        return $this->belongsTo(Kanban::class);
    }

    public function participants():BelongsToMany
    {
        return $this->belongsToMany(Participant::class);
    }
}
