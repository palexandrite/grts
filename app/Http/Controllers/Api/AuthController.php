<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\{
    Crypt,
    Hash,
    Log,
    Validator
};

class AuthController extends Controller
{
    /**
     * Handle an incoming registration request within Api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     *
     * @throws string
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'device_name' => ['required', 'string'],
        ]);

        if ( $validator->fails() ) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        try {
            $decrypted = Crypt::decryptString($request->device_name);
        } catch (DecryptException $e) {
            $errorMessage = $e->getMessage();
            Log::emergency("We have encountered with next error: $errorMessage. It is occured when we tryed to decrypt the value by Illuminate\Support\Facades\Crypt");

            return response()
                ->json(['errors' => 'Hey mate! There is a server error is occured'], 500);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'device_name' => $decrypted,
        ]);

        $token = $user->createToken($decrypted)->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', Password::defaults()],
            'device_name' => ['required', 'string'],
        ]);

        if ( $validator->fails() ) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => 'The provided credentials are incorrect.'], 401);
        }

        try {
            $decrypted = Crypt::decryptString($request->device_name);
        } catch (DecryptException $e) {
            $errorMessage = $e->getMessage();
            Log::emergency("We have encountered with next error: $errorMessage. It is occured when we tryed to decrypt the value by Illuminate\Support\Facades\Crypt");

            return response()
                ->json(['errors' => 'Hey mate! There is a server error is occured'], 500);
        }

        return ['token' => $user->createToken($decrypted)->plainTextToken];
    }
}
