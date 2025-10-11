<?php

namespace App\Actions;

use App\Models\Task;

class UpdateBaseTaskAction
{
    public function handle(Task $task, array $data) {
        $task->update($data);
    }
}
