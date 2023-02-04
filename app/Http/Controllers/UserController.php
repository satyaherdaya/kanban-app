<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

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
            $created = Carbon::now('Asia/Phnom_Penh');
            $createds = explode(' ', $created);

            $user = new User();
            $user->name = $valid['name'];
            $user->email = $valid['email'];
            $user->password = $createds[1] . $valid['password'] . $createds[0];
            $user->created_at = $created;
            $user->updated_at = $created;
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
            $user = User::where('email', $valid['email'])->first();
            $creds = explode(' ', $user->created_at);
            $pass = $creds[1] . $valid['password'] . $creds[0];
            if (Hash::check($pass, $user->password)) {
                $this->createUserSession($request, $user);
                return redirect('/dashboard');
            } else {
                return redirect('/login');
            }
        } else {
            return redirect('/login');
        }
    }

    public function logout(Request $request)
    {
        UserSession::where('uuid', $request->session()->get('user_session'))->delete();
        $request->session()->forget('user_session');
        return redirect('/login');
    }

    public function createUserSession(Request $request, $user)
    {
        $time = Carbon::now()->timezone('Asia/Phnom_Penh');
        $request->session()->put('user_session', (string)Uuid::uuid4());
        $user_session = new UserSession();
        $user_session->uuid = $request->session()->get('user_session');
        $user_session->user_id = $user->id;
        $user_session->lifetime = $time->addHours(2);
        $user_session->created_at = $time->subHours(2);
        $user_session->save();
    }

    public function dashboard(Request $request)
    {
        $user_session = UserSession::where('uuid', $request->session()->get('user_session'))->first();
        $categories = Category::where('user_id', $user_session->user_id)->get();

        return view('dashboard', ['categories' => $categories]);
    }
}
