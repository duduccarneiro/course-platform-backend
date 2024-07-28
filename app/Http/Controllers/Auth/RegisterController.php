<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\RegisterUserData;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function store(RegisterUserData $data)
    {

        return $data->toArray();
    }
}
