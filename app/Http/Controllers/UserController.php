<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $valid = $request->validate(
            [
                'name' => 'required|string',
                'email' => ['required', 'email'],
                'password' => 'required|string'
            ]
        );

        if ($valid != null) {
            $user = new User();
            $user->name = $valid['name'];
            $user->email = $valid['email'];
            $user->password = $valid['password'];
            $user->save();

            $usr = User::select('id')->where('email', $valid['email'])->first();

            Category::upsert(
                [
                    ['title' => 'todo', 'user_id' => $usr->id],
                    ['title' => 'in progress', 'user_id' => $usr->id],
                    ['title' => 'done', 'user_id' => $usr->id],
                    ['title' => 'backlog', 'user_id' => $usr->id]
                ],
                ['title'],
                null
            );

            return $this->login($request);
        }

        return redirect('/register');
    }

    public function login(Request $request)
    {
        $valid = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => 'required|string'
            ]
        );

        if ($valid != null) {
            $user = User::select('id')->where('email', $valid['email'])->first();
            if (Hash::check($valid['password'], $user->password)) {
                $request->session()->put('user_session', $user->id);
                return response('success');
            } else {
                return response('failed');
            }
        } else {
            return response('failed');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user_session');
        return response('success');
    }
}
