<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class authController extends Controller
{
    function login()
    {
        return Socialite::driver('google')->redirect();
    }
    function callback()
    {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('email',$google_user->email)->first();
            if($user){
                Auth::login($user);
                return redirect('user');
            }else{
                $new_user = User::create([
                    'name' => ucwords($google_user->name),
                    'email' => $google_user->email,
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'remember_token' => Str::random(10),
                    'google_id' => $google_user->id,
                ]);
                Auth::login($new_user);
                return redirect('user');
            }
   
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
