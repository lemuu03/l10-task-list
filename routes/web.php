<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () { //if a function is not defined in the route, you need to use the use function to define
    return view('index', [
        'tasks' => Task::latest()->paginate(10)
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')
    ->name('tasks.create');

Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', [
        'task' => $task
    ]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function (Task $task) {
    return view('show', [
        'task' => $task
    ]);
})->name('tasks.show');

# CREATE A TASK
Route::post('/tasks', function (TaskRequest $request) {

    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
    ->with('success', 'Task created successfully');
})->name('tasks.store');

# EDIT A TASK
Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    // $data = ;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->completed = $data['completed'];

    $task->update($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
    ->with('success', 'Task updated successfully');
})->name('tasks.update');

# DELETE A TASK
Route::delete('/tasks/{task}', function (Task $task){
    $task->delete();

    return redirect()->route('tasks.index')
        ->with('success', 'Task deleted successfully');
})->name('tasks.destroy');

Route::put('/tasks/{task}/toggle-complete', function(Task $task) { #Task $task to fetch the $task
    $task->toggleComplete();
    return redirect()->back()->with('success', 'Task updated successfully');
})->name('tasks.toggle-complete');

Route::fallback(function () {
    return 'Still got somewhere!';
});
