<?php

namespace App\Data\Auth;

use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Data;

class RegisterUserData extends Data
{
    public string $first_name;
    public string $last_name;
    public string $username;
    public string $email;
    public string $password;

    public static function rules() : array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
