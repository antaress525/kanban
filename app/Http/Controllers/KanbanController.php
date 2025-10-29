<?php

namespace App\Http\Controllers;

use App\Http\Resources\KanbanResource;
use Inertia\Inertia;
use App\Models\Kanban;
use App\Enums\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Actions\CreateKanbanAction;
use App\Actions\DeleteKanbanAction;
use App\Actions\UpdateCoverAction;
use App\Http\Requests\KanbanRequest;
use App\Http\Requests\UpdateKanbanCoverRequest;
use Illuminate\Support\Facades\Storage;

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
                $data = $kanban->tasks()->ordered()->where('status', operator: $status)->get();
                return [
                    $status => [
                        'total' => $data->count(),
                        'data' => $data,
                ],
            ];
        });
        return Inertia::render('Kanban/Show', [
            'kanban' => new KanbanResource($kanban),
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
        $query =  trim($request->input('q', ''));
        if($query === ''){
            return response()->json([]);
        }
        $results = Kanban::search($query)->get();
        return response()->json($results);
    }

    public function updateCover(Kanban $kanban, UpdateKanbanCoverRequest $request, UpdateCoverAction $action) {
        /**
         * @var UploadedFile $image
         */
        $cover = $request->validated('cover_image');
        $action->handle($kanban, $cover);
        return back()->with('success', 'Image de couverture mise à jour !');
    }
}
