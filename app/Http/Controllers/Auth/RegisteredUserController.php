<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $type = $request->query('type');
        return view('auth.register', ['type' => $type]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            // If type is set in the URL, override the role
            if ($request->query('type')) {
                $request->merge(['role' => $request->query('type')]);
            }

            // Build validation rules
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:20', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'string', 'in:farmer,cooperative_member,supplier,admin'],
                'language' => ['required', 'string', 'in:en,rw'],
                'location' => ['required', 'string', 'max:255'],
            ];

            // Validate all fields at once
            $validated = $request->validate($rules);

            DB::beginTransaction();
            try {
                // Create the user
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'password' => Hash::make($validated['password']),
                    'role' => $validated['role'],
                    'language' => $validated['language'],
                    'location' => $validated['location'],
                    'sms_notifications' => true,
                ]);

                event(new Registered($user));

                // Set the user's preferred language in session
                session(['locale' => $validated['language']]);
                App::setLocale($validated['language']);

                Auth::login($user);

                DB::commit();

                // Redirect based on role
                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'cooperative_member':
                        return redirect()->route('cooperative.dashboard');
                    case 'supplier':
                        return redirect()->route('supplier.dashboard');
                    case 'farmer':
                        return redirect()->route('farmer.dashboard');
                    default:
                        return redirect()->route('home');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ValidationException $e) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage(), [
                'request' => $request->except(['password', 'password_confirmation']),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['error' => __('An error occurred during registration. Please try again.')]);
        }
    }
}
