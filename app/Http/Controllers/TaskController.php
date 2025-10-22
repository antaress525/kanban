<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Kanban;
use App\Actions\CreateTaskAction;
use Illuminate\Support\Facades\DB;
use App\Actions\UpdateBaseTaskAction;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\ReoderTaskRequest;
use App\Http\Requests\UpdateBaseTaskRequest;

class TaskController extends Controller
{
    public function store(Kanban $kanban, CreateTaskRequest $request, CreateTaskAction $action) {
       $action->handle($kanban, $request->validated());
    }

    public function updateBase(Task $task, UpdateBaseTaskRequest $request, UpdateBaseTaskAction $action) {
        $attributes = $request->validated();
        $action->handle($task, $attributes);
    }

    /**
     * Gère la mise à jour du statut et de l'ordre des tâches après un drag-and-drop.
     */
    public function reorder(ReoderTaskRequest $request, Task $task)
    {
        $attributes = $request->validated();
        $newStatus = $attributes['status'];
        $taskOrder = $attributes['task_order'];

        DB::transaction(function () use ($task, $newStatus, $taskOrder) {
            // 1. Mettre à jour le statut de la tâche si elle a changé de colonne
            if ($task->status !== $newStatus) {
                $task->status = $newStatus;
                $task->save();
            }

            // 2. Mettre à jour le champ 'order' pour toutes les tâches de la liste reçue
            foreach ($taskOrder as $index => $taskId) {
                // Utiliser la même transaction pour tout mettre à jour
                Task::where('id', $taskId)
                    ->where('kanban_id', $task->kanban_id) // Sécurité
                    ->update(['order' => $index]); // L'index est le nouvel ordre
            }
        });

        // Utiliser back() et preserveState dans Inertia pour une mise à jour douce
        return back()->with('success', 'Tâche déplacée avec succès.');
    }
}
