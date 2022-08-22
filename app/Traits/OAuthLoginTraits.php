<?php

namespace App\Traits;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

trait OAuthLoginTraits
{
   public function driverRedirect()
   {
      return Socialite::driver($this->driverType())->redirect();
   }

   public function driverCallback()
   {
      try {

         $user = Socialite::driver($this->driverType())->user();

         $userExiste = User::where('oauth_id', $user->id)->where('oauth_type', $this->driverType())->first();

         if ($userExiste) {

            Auth::login($userExiste);

            return redirect()->route('dashboard');
         } else {

            $newUser = User::create([
               'name' => $user->name,
               'email' => $user->email,
               'oauth_id' => $user->id,
               'oauth_type' => $this->driverType(),
               'password' => Hash::make($user->id)
            ]);

            Auth::login($newUser);

            return redirect()->route('dashboard');
         }
      } catch (Exception $e) {
         dd($e);
      }
   }

   abstract  function driverType();
}