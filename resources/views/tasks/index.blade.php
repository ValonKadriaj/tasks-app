<x-app-layout title="Tasks">

    <form class="row g-2 mb-3" method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div class="col-auto">
            <input name="name" class="form-control" placeholder="New task name" required>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Add Task</button>
        </div>
    </form>

    <div class="mb-2"></div>

    <ul id="tasks-list" class="list-group">
        @foreach($tasks as $task)
            <x-task-item :task="$task" />
        @endforeach
    </ul>

    <form id="reorder-form" method="POST" action="{{ route('tasks.reorder') }}" style="display:none">@csrf</form>

        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            const el = document.getElementById('tasks-list');
            Sortable.create(el, {
                animation: 150,
                onStart: function (/**Event*/evt) {
                    // add dragging class to all draggable items to change cursor
                    el.querySelectorAll('.draggable').forEach(li => li.classList.add('dragging'));
                },
                onEnd: function (/**Event*/evt) {
                    // remove dragging class
                    el.querySelectorAll('.draggable').forEach(li => li.classList.remove('dragging'));
                    const ids = Array.from(el.querySelectorAll('li')).map(li => li.dataset.id);
                    fetch('{{ route('tasks.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: ids })
                    }).then(r => r.json()).then(data => {
                        if (data.status === 'ok') location.reload();
                    });
                }
                
            });

            function editTask(id, name) {
                const newName = prompt('Edit task name', name);
                if (newName === null) return;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/tasks/' + id;
                const _token = document.createElement('input'); _token.type='hidden'; _token.name='_token'; _token.value='{{ csrf_token() }}'; form.appendChild(_token);
                const _method = document.createElement('input'); _method.type='hidden'; _method.name='_method'; _method.value='PUT'; form.appendChild(_method);
                const nameIn = document.createElement('input'); nameIn.type='hidden'; nameIn.name='name'; nameIn.value=newName; form.appendChild(nameIn);
                document.body.appendChild(form);
                form.submit();
            }
        </script>

</x-app-layout>
