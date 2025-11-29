<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::orderBy('priority')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(TaskRequest $request)
    {
        $data = $request->validated();  
        $max = Task::max('priority');

        $data['priority'] = is_null($max) ? 1 : $max + 1;

        $task = Task::create($data);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function update(TaskRequest $request, Task $task)
    {
       
        $task->update($request->validated());

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        DB::transaction(function () {
            $tasks = Task::orderBy('priority')->get();
            $i = 1;
            foreach ($tasks as $t) {
                $t->update(['priority' => $i++]);
            }
        });

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);

        $order = $request->input('order');

        DB::transaction(function () use ($order) {
            $i = 1;
            foreach ($order as $id) {
                Task::where('id', $id)->update(['priority' => $i++]);
            }
        });

        return response()->json(['status' => 'ok']);
    }
}
