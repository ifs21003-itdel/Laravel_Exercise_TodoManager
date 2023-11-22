@extends("layouts.app")

@section('content')
    <div>
        <div class="text-center">
            <img src="{{$user->photo ? asset($user->photo) : asset("img/users/default.png")}}" style="border-radius: 50%; width: 150px; height: 150px;" alt="profile">
            <div class="py-2"></div>
            <form id="formUploadPhoto" action="{{route("post.me.photo")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input onchange="document.getElementById('formUploadPhoto').submit();" type="file" name="photo" id="photoProfile" class="d-none" accept="image/png, image/jpeg">
                <label for="photoProfile" class="btn btn-outline-primary">Ubah Photo Profile</label>
            </form>
            
            <!-- FITUR UBAH USERNAME -->
            <button type="button" class="mt-2 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditUsername">
                Ubah Username
            </button>

            <!-- Modal FITUR UBAH USERNAME -->
            <div class="modal fade" id="modalEditUsername" tabindex="-1" aria-labelledby="modalEditUsername" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditUsername">Ubah Username</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('post.me.username') }}">
                            @csrf

                            <div class="modal-body ">
                                <label class="d-flex justify-content-start" for="inputUsername">Username</label>
                                <input type="text" class="form-control mb-3" id="inputUsername" name="username" value="{{ $auth->name }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- FITUR UBAH PASSWORD -->
            <button type="button" class="mt-2 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditPassword">
                Ubah Password
            </button>

            <!-- Modal FITUR UBAH PASSWORD -->
            <div class="modal fade" id="modalEditPassword" tabindex="-1" aria-labelledby="modalEditPassword" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditPassword">Ubah Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('post.me.password') }}">
                            @csrf

                            <div class="modal-body ">
                                
                                <label class="d-flex justify-content-start" for="inputPassword">Password</label>
                                <input type="password" class="form-control mb-3" id="inputPassword" name="password">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- FITUR UBAH EMAIL -->
            <button type="button" class="mt-2 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditEmail">
                Ubah Email
            </button>

            <!-- MODAL FITUR UBAH EMAIL -->
            <div class="modal fade" id="modalEditEmail" tabindex="-1" aria-labelledby="modalEditEmail" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditEmail">Ubah Email</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('post.me.email') }}">
                            @csrf

                            <div class="modal-body ">
                                <label class="d-flex justify-content-start" for="inputEmail">Email</label>
                                <input type="email" class="form-control mb-3" id="inputEmail" name="email" value="{{ $auth->email }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
@endsection
