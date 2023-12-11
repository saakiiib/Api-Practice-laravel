<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\UserRequest;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(UserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('laravel_token')->plainTextToken
        ]);
    }
}
