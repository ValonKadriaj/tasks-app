<li class="list-group-item d-flex justify-content-between align-items-center draggable" data-id="{{ $task->id }}">
    <div>
        <strong>#{{ $task->priority }}</strong>
        {{ $task->name }}
    </div>
    <div>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline" onsubmit="return confirm('Delete this task? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
        </form>
        <button class="btn btn-sm btn-outline-secondary" onclick="editTask({{ $task->id }}, '{{ addslashes($task->name) }}')">Edit</button>
    </div>
</li>
