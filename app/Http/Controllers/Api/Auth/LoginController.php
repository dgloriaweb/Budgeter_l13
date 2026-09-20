<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;

#[Group('Auth', 'User registration and authentication.')]
class LoginController extends Controller
{
    #[Endpoint('Login', 'Authenticate a user and return an API token.')]
    #[BodyParam('email', 'string', 'User email address.', required: true, example: '{{email}}')]
    #[BodyParam('password', 'string', 'Password.', required: true, example: '{{password}}')]
    #[Response([
        'success' => true,
        'user' => [
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test.user@example.com',
        ],
        'token' => '1|{token}',
    ], status: 200)]
    public function __invoke(Request $request): JsonResponse
    {
        $validated_data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->where('email', $validated_data['email'])->first();

        if (!$user || !Hash::check($validated_data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ]);
    }
}

