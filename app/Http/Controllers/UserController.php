<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsersRoleAdmin()
    {
        $auth = Auth::user();
        $users = User::select('id', 'name', 'email', 'role', 'created_at', 'photo')
            ->selectRaw('(SELECT COUNT(*) FROM todos WHERE todos.user_id = users.id) as total_todo')
            ->orderBy("role", "desc")
            ->orderBy("name", "asc")
            ->get();

        $todos = Todo::select("*");
        $todos = $todos->orderBy("id", "desc")->get();
        
        $data = [
            'auth' => $auth,
            'todos' => $todos,
            'users' => $users
        ];
        return view('app.admin.users', $data);
    }
    public function getMe()
    {
        $auth = Auth::user();
        $user = $auth;
        $data = [
            'auth' => $auth,
            'user' => $user
        ];
        return view('app.user.profile', $data);
    }
    public function postPhotoProfile(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:1024',
        ]);
        $auth = Auth::user();
        // Mengambil file yang sudah divalidasi dari request
        $photo = $request->file('photo');
        // Membuat nama unik untuk file yang diunggah
        $filename = $auth->id . "_" . time() . '.' . $photo->getClientOriginalExtension();
        // Menentukan direktori tempat penyimpanan file di dalam direktori 'public'
        $directory = public_path('img/users');
        // Pindahkan file ke direktori yang diinginkan
        $photo->move($directory, $filename);
        $user = User::where("id", $auth->id)->first();
        // Menghapus photo lama jika ada
        if ($user->photo && file_exists($user->photo)) {
            unlink($user->photo);
        }
        $user->photo = "img/users/" . $filename;
        $user->save();
        return redirect()->back();
    }

    public function postUsername(Request $request)
    {
        $user = Auth::user();

        if(!empty($request->input("username"))){
            $user->name = $request->input("username");
        }

        $user->save();

        return redirect()->back();
    }

    public function postPassword(Request $request)
    {
        $user = Auth::user();

        if(!empty($request->input("password"))) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->back();
    }

    public function postEmail(Request $request)
    {
        $user = Auth::user();

        if(!empty($request->input("email"))){
            $user->email = $request->input("email");
        }

        $user->save();

        return redirect()->back();
    }
}
