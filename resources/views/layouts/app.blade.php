<!DOCTYPE html>
<html>

<head>
    <title>PABWE Praktikum 10</title>
    <link href="{{ asset('assets/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="container-fluid p-5">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <h3>Hay, <span class="text-primary">{{ $auth->name }}</span></h3>
                    </div>
                    <div>
                        <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                    </div>
                </div>

                <div class="mb-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('me') ? 'active' : '' }}"
                                href="{{ route('me') }}">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                Kelola Todolist
                            </a>
                        </li>
                        @if ($auth->role == 'Admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}"
                                    href="{{ route('admin.users') }}">
                                    Kelola Users
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                @yield('content')

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js') }}"></script>

    @yield('other-js')

</body>

</html>
