<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:cooperative_member,supplier'],
            'language' => ['required', 'in:en,rw'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'language' => $request->language,
        ]);

        // If user is a supplier, create supplier profile
        if ($request->role === 'supplier') {
            $request->validate([
                'company_name' => ['required', 'string', 'max:255'],
                'business_type' => ['required', 'string', 'max:255'],
                'location' => ['required', 'string', 'max:255'],
            ]);

            $user->supplier()->create([
                'company_name' => $request->company_name,
                'business_type' => $request->business_type,
                'location' => $request->location,
            ]);
        }

        Auth::login($user);

        return redirect()->route('home')->with('success', __('Registration successful! Welcome to Huza Muhinzi.'));
    }
}
