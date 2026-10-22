<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'name.required'     => 'Please fill in your name and password.',
            'password.required' => 'Please fill in your name and password.',
        ]);

        $attempt = [
            'name_key' => Str::lower(trim($data['name'])),
            'password' => $data['password'],
        ];

        if (! Auth::attempt($attempt, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('name'))
                ->withErrors(['name' => 'Name or password is incorrect.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}