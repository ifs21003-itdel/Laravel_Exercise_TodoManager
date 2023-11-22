@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between mb-3">
        <div>
            <h3>Kelola Users ({{sizeof($users) ?? 0}})</h3>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Total Todolist</th>
                <th scope="col">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($users) && sizeof($users) > 0)
                @php
                    $counterUser = 1;
                @endphp
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $counterUser++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-success">{{ $user->role }}</span>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $user->total_todo ?? 0 }}</span>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="#" data-bs-toggle="modal"
                            data-bs-target="#profileModal-{{ $counterUser }}">Lihat Profile</a>
                            <!-- Modal Untuk Profile Tiap User -->
                            <div class="modal fade" id="profileModal-{{ $counterUser }}" tabindex="-1"
                                aria-labelledby="profileModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="profileModalLabel">{{ $user->name }}' Profile
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <div class="text-center">
                                                    <img src="{{$user->photo ? asset($user->photo) : asset("img/users/default.png")}}" style="border-radius: 50%; width: 150px; height: 150px;" alt="profile">
                                                    <div class="py-2"></div>
                                                </div>
                                                <div class="col-5 mx-auto mt-4">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Nama</th>
                                                            <td>{{$user->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Email</th>
                                                            <td>{{$user->email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Role</th>
                                                            <td>{{$user->role}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Bergabung Sejak</th>
                                                            <td>{{date("d F Y - H:i", strtotime($user->created_at))}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <a class="btn btn-sm btn-outline-primary" href="#" data-bs-toggle="modal"
                                data-bs-target="#todolistModal-{{ $counterUser }}">Lihat Todolist</a>
                            <!-- Modal Untuk Todolist Tiap User -->
                            <div class="modal fade" id="todolistModal-{{ $counterUser }}" tabindex="-1"
                                aria-labelledby="todolistModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="todolistModalLabel">Todolist for {{ $user->name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Aktivitas</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Tanggal Dibuat</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($todos) && sizeof($todos) > 0)
                                                        @php
                                                            $counterTodo = 1;
                                                            
                                                        @endphp
                                                        @foreach ($todos as $todo)
                                                            @if ($todo->user_id === $user->id)
                                                                <tr>
                                                                    <td>{{ $counterTodo++ }}</td>
                                                                    <td>{{ $todo->activity }}</td>
                                                                    <td>
                                                                        @if ($todo->status)
                                                                            <span class="badge bg-success">Selesai</span>
                                                                        @else
                                                                            <span class="badge bg-danger">Belum
                                                                                Selesai</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ date('d F Y - H:i', strtotime($todo->created_at)) }}
                                                                    </td>

                                                                </tr>
                                                            @endif
                                                            
                                                            
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">Belum ada data
                                                                tersedia!</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

@endsection
