@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Forget Password</div>

                    <div class="card-body">

                        @if(Session::get("success"))
                            <div class="alert alert-success" role="alert">
                                {{Session::get("success")}}
                            </div>
                        @endif


                        <form method="POST" action="{{ route('post.forget-password') }}">
                            @csrf

                            <div class="form-group mb-2">
                                <label for="email">Alamat Email</label>
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')
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

                            <hr />

                            <div class="mb-2 text-center">
                                <span>Sudah ingat? <a href="{{ route("login") }}">masuk disini</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
