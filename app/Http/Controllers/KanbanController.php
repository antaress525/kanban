<?php

namespace App\Http\Controllers;

use App\Actions\CreateKanbanAction;
use App\Actions\DeleteKanbanAction;
use App\Enums\TaskStatus;
use App\Http\Requests\KanbanRequest;
use App\Models\Kanban;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KanbanController extends Controller
{
    public function index()
    {
        return Inertia::render('Kanban/Index');
    }

    public function store(KanbanRequest $request, CreateKanbanAction $action) {
        $kanban = $action->handle($request->validated());
        return to_route('kanban.show', $kanban);
    }

    public function show(Kanban $kanban) {
        $kanban = $kanban->load('tasks');
        $statuses = array_column(TaskStatus::cases(), 'value');
        $tasks = collect($statuses)
            ->mapWithKeys(function ($status) use ($kanban) {
                $data = $kanban->tasks()->where('status', operator: $status)->get();
                return [
                    $status => [
                        'total' => $data->count(),
                        'data' => $data,
                ],
            ];
        });
        return Inertia::render('Kanban/Show', [
            'kanban' => $kanban,
            'tasks' => $tasks
        ]);
    }

    public function delete(Kanban $kanban, DeleteKanbanAction $action) {
        $kanban = $action->handle($kanban);
        if($kanban) {
            return to_route('kanban.show', $kanban);
        }
        return to_route('kanban.index');
    }

    public function search(Request $request) {
        sleep(1);
        $query =  trim($request->input('q', ''));
        if($query === ''){
            return response()->json([]);
        }
        $results = Kanban::search($query)->get();
        return response()->json($results);
    }
}
