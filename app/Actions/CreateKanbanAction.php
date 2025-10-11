<?php

namespace App\Actions;

use App\Models\Kanban;
use Illuminate\Support\Facades\Auth;

class CreateKanbanAction
{
    public function handle(array $data):Kanban {
        $kanban = Auth::user()->kanbans()->create($data);
        return $kanban;
    }
}
