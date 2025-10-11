<?php

namespace App\Actions;

use App\Models\Kanban;
use Illuminate\Support\Facades\Auth;

class DeleteKanbanAction
{
    public function handle(Kanban $kanban): Kanban|null {
        $kanban->delete();
        $kanban = Auth::user()->kanbans()->first();
        return $kanban;
    }
}
