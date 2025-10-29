<?php

namespace App\Actions;

use App\Models\Kanban;
use Illuminate\Support\Facades\Storage;

class DeleteCoverAction
{
    public function handle(Kanban $kanban) {
        Storage::disk('public')->delete($kanban->cover_image);
            $kanban->update([
                'cover_image' => null
        ]);
    }
}
