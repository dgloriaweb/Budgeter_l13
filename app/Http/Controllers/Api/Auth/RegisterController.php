<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;

#[Group('Auth', 'User registration and authentication.')]
class RegisterController extends Controller
{
    #[Endpoint('Register', 'Create a user and return an API token.')]
    #[BodyParam('name', 'string', 'User name.', required: true, example: 'Test User')]
    #[BodyParam('email', 'string', 'User email address.', required: true, example: 'test.user@example.com')]
    #[BodyParam('password', 'string', 'Password.', required: true, example: 'Password123!')]
    #[BodyParam('password_confirmation', 'string', 'Must match password.', required: true, example: 'Password123!')]
    #[Response([
        'success' => true,
        'user' => [
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test.user@example.com',
        ],
        'token' => '1|{token}',
    ], status: 201)]
    public function __invoke(Request $request): JsonResponse
    {
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated_data['name'],
            'email' => $validated_data['email'],
            'password' => Hash::make($validated_data['password']),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ], 201);
    }
}

