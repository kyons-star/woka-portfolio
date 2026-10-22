<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['name' => trim((string) $request->input('name'))]);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Please enter your full name.',
            'password.min'       => 'Password needs at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $key = Str::lower($data['name']);

        if (User::where('name_key', $key)->exists()) {
            return back()
                ->withInput($request->only('name'))
                ->withErrors(['name' => 'That name already has an account. Try logging in.']);
        }

        $user = User::create([
            'name'     => $data['name'],
            'name_key' => $key,
            'password' => $data['password'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}