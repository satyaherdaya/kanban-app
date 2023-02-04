<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\UserSession;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function save(Request $request)
    {
        $valid = $request->validate(
            [
                'title' => 'required|string'
            ]
        );

        if ($valid != null) {
            $user = UserSession::where('uuid', $request->session()->get('user_session'))->first();

            $category = new Category();
            $category->title = $valid['title'];
            $category->user_id = $user->user_id;
            $category->save();

            return redirect('/dashboard');
        }

        return redirect('/category/create');
    }

    public function update(Request $request)
    {
        $valid = $request->validate(
            [
                'title' => 'required|string'
            ]
        );

        if ($valid != null) {
            $user = UserSession::where('uuid', $request->session()->get('user_session'))->first();

            $category = new Category();
            $category->title = $valid['title'];
            $category->user_id = $user->user_id;
            $category->save();

            return redirect('/dashboard');
        }

        return redirect('/category/update');
    }

    public function delete($id)
    {
        Category::where('id', $id)->delete();
        return redirect('/dashboard');
    }
}
