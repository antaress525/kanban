<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Kanban extends Model
{
    /** @use HasFactory<\Database\Factories\KanbanFactory> */
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'description',
        'color',
        'cover_image',
        'user_id',
    ];

    public function owner():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks():HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function participants():HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function toSearchableArray() 
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at->timestamp,
        ];

    }
}
