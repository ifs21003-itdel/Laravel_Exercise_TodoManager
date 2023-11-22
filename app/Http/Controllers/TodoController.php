<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
  public function index(Request $request)
  {
    $auth = Auth::user();

    // Ambil query pencarian
    $keywords = $request->query("keywords") ?? null;
    $status = $request->query("status") ?? null;

    $todos = Todo::where("user_id", $auth->id);
    if($keywords != null){
      $todos = $todos->where("activity", "LIKE", "%$keywords%");
    }

    if($status != null){
      $todos = $todos->where("status", $status);
    }
    
    $todos = $todos->orderBy("created_at", "desc")->get();
    $data = [
      "auth" => $auth,
      "todos" => $todos
    ];

    return view("app.home", $data);
  }

  public function postAdd(Request $request)
{
    $validator = Validator::make($request->all(), [
        'activity' => 'required|string|max:255'
    ]);

    if ($validator->fails()) {
        return redirect()
            ->route('home')
            ->withErrors($validator)
            ->withInput();
    }

    
    $auth = Auth::user();

    Todo::create([
      "user_id" => $auth->id,
      "activity" => $request->activity,
    ]);

    return redirect()->route("home");
  }

  public function postEdit(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:todos',
        'activity' => 'required|string|max:255',
        'status' => 'required|boolean',
    ]);

    if ($validator->fails()) {
        return redirect()
            ->route('home')
            ->withErrors($validator)
            ->withInput();
    }

    $auth = Auth::user();

    $todo = Todo::where("id", $request->id)->where("user_id", $auth->id)->first();
    if ($todo) {
      $todo->activity = $request->activity;
      $todo->status = $request->status;
      $todo->save();
    }

    return redirect()->route("home");
  }

  public function postDelete(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'id' => 'required|exists:todos',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->route('home')
        ->withErrors($validator)
        ->withInput();
    }

    $auth = Auth::user();

    $todo = Todo::where("id", $request->id)->where("user_id", $auth->id)->first();
    if ($todo) {
      $todo->delete();
    }

    return redirect()->route("home");
  }
}