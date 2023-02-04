<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\UserSession;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function save(Request $request)
    {
        $valid = $request->validate(
            [
                'title' => 'required|string',
                'description' => 'required|string',
                'category_id' => 'required'
            ]
        );

        if ($valid != null) {
            $user = UserSession::where('uuid', $request->session()->get('user_session'))->first();

            $task = new Task();
            $task->title = $valid['title'];
            $task->description = $valid['description'];
            $task->category_id = $valid['category_id'];
            $task->user_id = $user->user_id;
            $task->save();

            return redirect('/dashboard');
        }

        return redirect('/task/create');
    }

    public function viewCreate($id)
    {
        $category = Category::find($id);

        return view('create_task', ['category' => $category]);
    }
}
