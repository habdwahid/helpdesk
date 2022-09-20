<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ManagerLoginController extends Controller
{
    /**
     * Render the Login View for Manager Role
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $title = 'Login';

        return view('auth.manager.login', compact('title'));
    }

    /**
     * Handle the Login request
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->login)
            ->orWhere('nip', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['login' => __('auth.failed')]);
        }

        if ($user->user_role->role_id !== 4) {
            throw ValidationException::withMessages(['login' => __('passwords.user')]);
        }

        auth()->login($user, true);

        $request->session()->regenerate();

        return to_route('manager.dashboard');
    }
}
