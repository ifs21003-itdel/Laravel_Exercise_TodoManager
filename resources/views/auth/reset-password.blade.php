@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Reset Password</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('post.reset-password') }}">
                            @csrf

                            <input type="hidden" value="{{$token}}" name="token">
                            <input type="hidden" value="{{$email}}" name="email">

                            <div class="form-group mb-2">
                                <label for="infoEmail">Alamat Email</label>
                                <input id="infoEmail" type="email" disabled
                                       class="form-control" value="{{ $email }}">
                            </div>

                            <div class="form-group mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password">Kata Sandi Baru</label>
                                </div>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    Kirim
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
