<?php

namespace App\Http\Resources;

use App\Models\Kanban;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class KanbanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'color' => $this->color,
            'cover_image' => $this->cover_image,
        ];
    }
}
