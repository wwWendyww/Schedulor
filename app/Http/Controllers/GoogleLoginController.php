<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
/* BCS3453 [PROJECT]-SEMESTER 2324/1
Student ID: CA20070
Student Name: Wendy Loh Li Wen
	 */
class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $getUser = User::where('google_id', '=', $user->id)->first();
            if($getUser){
                Auth::login($getUser);
                return redirect()->route('profile');
            }
            else{
                $createUser =  User::create([
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'google_id' => $user->id,
                    'user_password' => encrypt('asd')
            ]);

            Auth::login($createUser);
            return redirect()->route('profile');

            }
        } catch (Exception $e) {
           dd($e->getMessage());
        }
    }
}