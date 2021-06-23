<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Crypt,
    Hash,
    Log
};

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $deviceName = Crypt::encryptString($request->ip() .'-'. $request->userAgent());

        return view('auth.register', [
            'deviceName' => $deviceName,
        ]);
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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'device_name' => 'required|string',
        ]);

        try {
            $decrypted = Crypt::decryptString($request->device_name);
        } catch (DecryptException $e) {
            $errorMessage = $e->getMessage();
            Log::emergency("We have encountered with next error: $errorMessage. It is occured when we tryed to decrypt the value by Illuminate\Support\Facades\Crypt");
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'device_name' => $decrypted,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
