<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $access_token = $request->user()?->currentAccessToken();

        if ($access_token) {
            $access_token->delete();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}

