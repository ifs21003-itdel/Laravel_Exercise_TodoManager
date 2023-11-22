<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
  public function getRegister(Request $request)
  {
    if (Auth::user()) {
      return redirect()->route("home");
    }
    return view("auth.register");
  }
  public function postRegister(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6',
    ]);
    $user = new User([
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => Hash::make($request->input('password')),
    ]);
    $user->save();
    Auth::login($user);
    return redirect()->route("home");
  }
  public function getLogin(Request $request)
  {
    if (Auth::user()) {
      return redirect()->route("home");
    }
    return view("auth.login");
  }
  public function postLogin(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255|exists:users',
      'password' => 'required|string|min:6',
    ]);
    $validator->after(function ($validator) use ($request) {
      $user = User::where('email', $request->email)->first();
      if (!$user || !Hash::check($request->password, $user->password)) {
        $validator->errors()->add('password', 'Password is
incorrect');
      } else {
        Auth::attempt(['email' => $request->email, 'password'
        => $request->password], $request->has('remember'));
      }
    });
    if ($validator->fails()) {
      return redirect()
        ->route('login')
        ->withErrors($validator)
        ->withInput();
    }
    return redirect()->route("home");
  }
  public function getForgetPassword(Request $request)
  {
    if (Auth::user()) {
      return redirect()->route("home");
    }
    return view("auth.forget-password");
  }
  public function postForgetPassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255|exists:users',
    ]);
    if ($validator->fails()) {
      return redirect()
        ->route('forget-password')
        ->withErrors($validator)
        ->withInput();
    }
    $randomToken = Str::random(12);
    DB::table("password_resets")->updateOrInsert(
      ['email' => $request->email],
      ['token' => $randomToken, 'created_at' => now()]
    );
    $user = User::where('email', $request->email)->first();
    $name = $user->name;
    $email = $user->email;
    $data = [
      'url' => route("reset-password", [
        "email" => $email,
        'token' => $randomToken
      ])
    ];
    Mail::send("email.reset-password", $data, function ($message)
    use ($email, $name, $randomToken) {
      $message->to($email, $name)
        ->subject('Reset Password - ' . $randomToken);
    });
    $message = "Berhasil mengirimkan email reset kata sandi.
Silahkan melakukan pengecekan ke alamat email kamu untuk dapat
melakukan reset kata sandi!";
    return redirect()->route("forget-password")->with(
      "success",
      $message
    );
  }
  public function getResetPassword(Request $request, $email, $token)
  {
    $password_reset = DB::table("password_resets")->where(
      "email",
      $email
    )->where("token", $token)->first();
    if (!$password_reset) {
      return redirect()->route("login");
    }
    $data = [
      'email' => $email,
      'token' => $token
    ];
    return view("auth.reset-password", $data);
  }
  public function postResetPassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'token' => 'required',
      'email' => 'required|exists:users',
      'password' => 'required|string|min:6',
    ]);
    if ($validator->fails()) {
      return redirect()
        ->route('reset-password')
        ->withErrors($validator)
        ->withInput();
    }
    // Memeriksa apakah password_reset tersedia
    $password_reset = DB::table("password_resets")->where(
      "email",
      $request->email
    )->where("token", $request->token)->first();
    if (!$password_reset) {
      return redirect()->route("login");
    }
    // Menghapus token reset-password
    DB::table("password_resets")->where("email", $request->email)->where("token", $request->token)->delete();
    // Mengubah kata sandi
    $user = User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();
    $message = "Berhasil mengubah kata sandi, silahkan masuk
menggunakan akun kamu!";
    return redirect()->route("login")->with("success", $message);
  }
  public function getLogout(Request $request)
  {
    Auth::logout();
    return redirect()->route("login");
  }
}
