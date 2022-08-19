<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{

    const GOOGLE_TYPE = 'google';

    public function googleRedirect()
    {
        return Socialite::driver(static::GOOGLE_TYPE)->redirect();
    }

    public function googleCallback()
    {
        try {

            $user = Socialite::driver(static::GOOGLE_TYPE)->user();

            $userExiste = User::where('oauth_id', $user->id)->where('oauth_type', static::GOOGLE_TYPE)->first();

            if ($userExiste) {

                Auth::login($userExiste);

                return redirect()->route('dashboard');
            } else {

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => static::GOOGLE_TYPE,
                    'password' => Hash::make($user->id)
                ]);

                Auth::login($newUser);

                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}