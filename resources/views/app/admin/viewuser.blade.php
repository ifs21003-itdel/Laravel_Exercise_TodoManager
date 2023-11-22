@extends('layouts.viewuser')

@section('content')

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