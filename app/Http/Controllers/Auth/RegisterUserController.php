<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Data\Auth\RegisterUserData;
use App\Http\Controllers\Controller;

class RegisterUserController extends Controller
{
    public function __invoke(RegisterUserData $data)
    {
        $user = RegisterUserAction::run($data);

        return response()->json($user, 201);
    }
}
