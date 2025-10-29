<?php

namespace App\Actions;

use App\Models\Kanban;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateCoverAction
{
    public function handle(Kanban $kanban, UploadedFile $cover) {
        if($kanban->cover_image) {
            Storage::disk('public')->delete($kanban->cover_image);
        }
        $path = $cover->store('kanban_covers', 'public');
        $kanban->cover_image = $path;
        $kanban->save();
    }
}
