<?php
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;

#[Group("System", "Endpoints related to application health and monitoring")]
class HealthCheckController extends Controller
{
    /**
     * System Healthcheck
     *
     * Check that the API service and server timestamp are operating normally.
     */
    #[Endpoint("Healthcheck", "Verify API server operational status.")]
    #[Response(["status" => "ok", "timestamp" => "2026-08-31T10:45:00Z"], status: 200)]
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}