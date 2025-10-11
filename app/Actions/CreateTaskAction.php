<?php

namespace App\Actions;

use App\Models\Kanban;

class CreateTaskAction
{
    public function handle(Kanban $kanban, array $data) {
        $task = $kanban->tasks()->create($data);
    }
}
