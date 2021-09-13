<?php


namespace App\Services;


use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterService
{
    public function register(RegisterRequest $request): User
    {
        $user = User::register($request->name, $request->email, $request->password);

        event(new Registered($user));

        return $user;
    }
}
