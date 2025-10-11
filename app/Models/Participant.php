<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\ParticipantFactory> */
    use HasFactory;

    public function tasks():BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    public function permission():BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

    public function kanban():BelongsTo
    {
        return $this->belongsTo(Kanban::class);
    }
}
