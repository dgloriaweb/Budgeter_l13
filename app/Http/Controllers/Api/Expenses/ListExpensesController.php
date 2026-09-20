<?php

namespace App\Http\Controllers\Api\Expenses;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response;

#[Group('Expenses', 'Import and manage expense rows.')]
#[Authenticated]
class ListExpensesController extends Controller
{
    #[Endpoint('List expenses', 'List expenses for the authenticated user (paginated).')]
    #[QueryParam('per_page', 'int', 'Items per page (max 200).', required: false, example: 50)]
    #[Response([
        'success' => true,
        'data' => [
            'current_page' => 1,
            'data' => [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'title' => 'Namesco ltd domain renewal',
                    'amount' => '-22.99',
                    'currency' => 'GBP',
                    'transaction_date' => null,
                    'due_date' => '2027-04-16',
                ],
            ],
        ],
    ], status: 200)]
    public function __invoke(Request $request): JsonResponse
    {
        $validated_data = $request->validate([
            'per_page' => ['nullable', 'integer', 'min:1', 'max:200'],
        ]);

        $per_page = $validated_data['per_page'] ?? 50;

        $expense_table_name = (new Expense())->getTable();

        if (! Schema::hasColumn($expense_table_name, 'user_id')) {
            return response()->json([
                'success' => false,
                'message' => "Database schema missing `{$expense_table_name}.user_id`. Run migrations to add it.",
            ], 500);
        }

        $query = Expense::query()
            ->where('user_id', $request->user()->id);

        if (Schema::hasColumn($expense_table_name, 'transaction_date')) {
            $query->orderByDesc('transaction_date');
        }

        if (Schema::hasColumn($expense_table_name, 'due_date')) {
            $query->orderByDesc('due_date');
        }

        $paginator = $query
            ->orderByDesc('id')
            ->paginate($per_page);

        return response()->json([
            'success' => true,
            'data' => $paginator,
        ]);
    }
}

