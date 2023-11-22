@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between mb-3">
        <div>
            <h3>Kelola Todolist Kamu ({{sizeof($todos)}})</h3>
        </div>
        <div class="text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodo">Tambah Data</button>
        </div>
    </div>

    <div>
        <form method="GET">
            <div class="input-group mb-3">
                <input name="keywords" type="text" class="form-control" placeholder="Cari todo..." value="{{request()->query("keywords")}}">
                <select name="status" class="form-select">
                    <option value="">Semua Todo</option>
                    <option {{ (request()->query("status") === 1 ? 'selected' : '') }} value="1">Todo Selesai</option>
                    <option {{ (request()->query("status") === 0 ? 'selected' : '') }} value="0">Todo Belum Selesai</option>
                </select>
                <button class="btn btn-primary" type="submit">Temukan</button>
            </div>
        </form>
    </div>
    <hr/>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Aktivitas</th>
            <th scope="col">Status</th>
            <th scope="col">Tanggal Dibuat</th>
            <th scope="col">Tindakan</th>
        </tr>
        </thead>
        <tbody>
        @if (isset($todos) && sizeof($todos) > 0)
            @php
                $counter = 1;
            @endphp
            @foreach ($todos as $todo)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $todo->activity }}</td>
                    <td>
                        @if ($todo->status)
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-danger">Belum Selesai</span>
                        @endif
                    </td>
                    <td>
                        {{ date('d F Y - H:i', strtotime($todo->created_at)) }}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning"
                                onclick="showModalEditTodo({{ $todo->id }}, '{{ $todo->activity }}', {{ $todo->status }})">
                            Ubah
                        </button>
                        <button class="btn btn-sm btn-danger"
                                onclick="showModalDeleteTodo({{ $todo->id }}, '{{ $todo->activity }}')">Hapus
                        </button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center text-muted">Belum ada data tersedia!</td>
            </tr>
        @endif

        </tbody>
    </table>

    <!-- MODAL ADD TODO -->
    <div class="modal fade" id="addTodo" tabindex="-1" aria-labelledby="addTodoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTodoLabel">Tambah Data Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('post.todo.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="inputActivity" class="form-label">Aktivitas</label>
                            <input type="text" name="activity" class="form-control" id="inputActivity"
                                   placeholder="Contoh: Belajar membuat aplikasi website sederhana">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT TODO -->
    <div class="modal fade" id="editTodo" tabindex="-1" aria-labelledby="editTodoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTodoLabel">Ubah Data Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('post.todo.edit') }}" method="POST">
                    @csrf
                    <input name="id" type="hidden" id="inputEditTodoId">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="inputEditActivity" class="form-label">Aktivitas</label>
                            <input type="text" name="activity" class="form-control" id="inputEditActivity"
                                   placeholder="Contoh: Belajar membuat aplikasi website sederhana">
                        </div>

                        <div class="mb-3">
                            <label for="selectEditStatus" class="form-label">Status</label>
                            <select class="form-select" name="status" id="selectEditStatus">
                                <option value="0">Belum Selesai</option>
                                <option value="1">Selesai</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE TODO -->
    <div class="modal fade" id="deleteTodo" tabindex="-1" aria-labelledby="deleteTodoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTodoLabel">Hapus Data Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        Kamu akan menghapus todo
                        <strong class="text-danger" id="deleteTodoActivity"></strong>.
                        Apakah kamu yakin?
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('post.todo.delete') }}" method="POST">
                        @csrf
                        <input name="id" type="hidden" id="inputDeleteTodoId">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Tetap Hapus</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('other-js')
    <script>
        function showModalEditTodo(todoId, activity, status) {
            const modalEditTodo = document.getElementById("editTodo");
            const inputId = document.getElementById("inputEditTodoId");
            const inputActivity = document.getElementById("inputEditActivity");
            const selectStatus = document.getElementById("selectEditStatus");

            inputId.value = todoId;
            inputActivity.value = activity;
            selectStatus.value = status;

            var myModal = new bootstrap.Modal(modalEditTodo)
            myModal.show()
        }

        function showModalDeleteTodo(todoId, activity) {
            const modalDeleteTodo = document.getElementById("deleteTodo");
            const elemntActivity = document.getElementById("deleteTodoActivity");
            const inputId = document.getElementById("inputDeleteTodoId");

            inputId.value = todoId;
            elemntActivity.innerText = activity;

            var myModal = new bootstrap.Modal(modalDeleteTodo)
            myModal.show()
        }
    </script>
@endsection
