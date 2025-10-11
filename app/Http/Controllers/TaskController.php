<?php

namespace App\Http\Controllers;

use App\Actions\CreateTaskAction;
use App\Actions\UpdateBaseTaskAction;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateBaseTaskRequest;
use App\Models\Kanban;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(Kanban $kanban, CreateTaskRequest $request, CreateTaskAction $action) {
       $action->handle($kanban, $request->validated());
    }

    public function updateBase(Task $task, UpdateBaseTaskRequest $request, UpdateBaseTaskAction $action) {
        $attributes = $request->validated();
        $action->handle($task, $attributes);
    }
}
