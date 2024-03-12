<h1>
    The list of tasks
</h1>


<div>
    @forelse ($tasks as $task)
        <div>{{$task->title}}</div>
    @empty
        <div>No tasks available</div>
    @endforelse
</div>
