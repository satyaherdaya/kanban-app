<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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

        return redirect('/task/create/' . Crypt::decryptString($request->category_id));
    }

    public function viewCreate($id)
    {
        $category = Category::find(Crypt::decryptString($id));

        return view('create_task', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        if ($request->input('title') != null && $request->input('description') != null) {
            $task = Task::find(Crypt::decryptString($id));
            $task->title = $request->input('title');
            $task->description = $request->input('description');
            $task->save();

            return redirect('/dashboard');
        } else if ($request->input('description') == null) {
            $task = Task::find(Crypt::decryptString($id));
            $task->title = $request->input('title');
            $task->save();

            return redirect('/dashboard');
        } else if ($request->input('title') == null) {
            $task = Task::find(Crypt::decryptString($id));
            $task->description = $request->input('description');
            $task->save();

            return redirect('/dashboard');
        }

        return redirect('/task/update/' . Crypt::decryptString($id));
    }

    public function updateView($id)
    {
        $task = Task::find(Crypt::decryptString($id));

        return view('update_task', ['task' => $task]);
    }

    public function delete($id)
    {
        Task::where('id', Crypt::decryptString($id))->delete();
        return redirect('/dashboard');
    }

    public function updateTaskCategory(Request $request)
    {
        if ($request->input('next') != null) {
            $task = Task::find(Crypt::decryptString($request->input('id')));
            $task->category_id = Crypt::decryptString($request->input('next'));
            $task->updated_at = Carbon::now()->timezone('Asia/Phnom_Penh');
            $task->save();
        } else if ($request->input('prev') != null) {
            $task = Task::find(Crypt::decryptString($request->input('id')));
            $task->category_id = Crypt::decryptString($request->input('prev'));
            $task->updated_at = Carbon::now()->timezone('Asia/Phnom_Penh');
            $task->save();
        }

        return redirect('dashboard');
    }
}
