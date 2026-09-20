<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;

#[Group('Auth', 'User registration and authentication.')]
#[Authenticated]
class MeController extends Controller
{
    #[Endpoint('Current user', 'Return the authenticated user.')]
    #[Response(['id' => 1, 'name' => 'Test User', 'email' => 'test.user@example.com'], status: 200)]
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}

