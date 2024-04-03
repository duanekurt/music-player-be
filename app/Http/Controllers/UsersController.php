<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegistrationUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    /**
     * API User login
     */
    public function login(LoginUserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw new NotFoundHttpException('These credentials does not match any in our records.');
        }

        // Create token
        $token = $user->createToken($user->id, ['*'], now()->addWeek())->plainTextToken;

        return ['token' => $token, 'user' => $user];
    }

    /**
     * API User Registration
     */
    public function register(RegistrationUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // Create token
        $token = $user->createToken($user->id, ['*'], now()->addWeek())->plainTextToken;

        return ['token' => $token, 'user' => $user];
    }
}
