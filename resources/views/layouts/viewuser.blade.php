<!DOCTYPE html>
<html>

<head>
    <title>PABWE Praktikum 8</title>
    <link href="{{ asset('assets/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
</head>

<body>
<div class="container-fluid p-5">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h3>This is <span class="text-primary">{{ $auth->name }}</span> Todo List</h3>
                </div>
            </div>

            @yield('content')

        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js') }}"></script>

@yield('other-js')

</body>

</html>
