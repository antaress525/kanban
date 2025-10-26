<?php

namespace App\Actions;

use App\Models\Task;

class BulkDeleteTaskAction
{
    public function handle(array $taskIds) {
        Task::destroy($taskIds);
    }
}
