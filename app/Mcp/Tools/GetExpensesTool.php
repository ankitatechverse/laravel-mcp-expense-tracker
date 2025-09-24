<?php

namespace App\Mcp\Tools;

use App\Models\Expense;
use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class GetExpensesTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Retrieve expenses with optional filtering by date range, payment method, or search terms.';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'payment_method' => 'nullable|string|in:cash,credit_card,debit_card,bank_transfer,digital_wallet',
            'search' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1|max:100',
            'sort_by' => 'nullable|string|in:amount,expense_date,created_at',
            'sort_order' => 'nullable|string|in:asc,desc',
        ]);

        $query = Expense::query();

        // Apply filters
        if (isset($validated['start_date'])) {
            $query->where('expense_date', '>=', $validated['start_date']);
        }

        if (isset($validated['end_date'])) {
            $query->where('expense_date', '<=', $validated['end_date']);
        }

        if (isset($validated['payment_method'])) {
            $query->where('payment_method', $validated['payment_method']);
        }

        if (isset($validated['search'])) {
            $query->where(function ($q) use ($validated) {
                $q->where('title', 'like', '%' . $validated['search'] . '%')
                  ->orWhere('description', 'like', '%' . $validated['search'] . '%');
            });
        }

        // Apply sorting
        $sortBy = $validated['sort_by'] ?? 'expense_date';
        $sortOrder = $validated['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        // Apply limit
        $limit = $validated['limit'] ?? 20;
        $expenses = $query->limit($limit)->get();

        $totalAmount = $expenses->sum('amount');

        return Response::json([
            'expenses' => $expenses->map(function ($expense) {
                return [
                    'id' => $expense->id,
                    'title' => $expense->title,
                    'description' => $expense->description,
                    'amount' => $expense->amount,
                    'expense_date' => $expense->expense_date->format('Y-m-d'),
                    'payment_method' => $expense->payment_method,
                    'created_at' => $expense->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'summary' => [
                'total_count' => $expenses->count(),
                'total_amount' => $totalAmount,
                'average_amount' => $expenses->count() > 0 ? round($totalAmount / $expenses->count(), 2) : 0,
            ],
        ]);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'start_date' => $schema->string()
                ->description('Filter expenses from this date (YYYY-MM-DD)'),
            'end_date' => $schema->string()
                ->description('Filter expenses until this date (YYYY-MM-DD)'),
            'payment_method' => $schema->string()
                ->enum(['cash', 'credit_card', 'debit_card', 'bank_transfer', 'digital_wallet'])
                ->description('Filter expenses by payment method'),
            'search' => $schema->string()
                ->description('Search expenses by title or description'),
            'limit' => $schema->integer()
                ->description('Maximum number of expenses to return (1-100)')
                ->default(20),
            'sort_by' => $schema->string()
                ->enum(['amount', 'expense_date', 'created_at'])
                ->description('Sort expenses by this field')
                ->default('expense_date'),
            'sort_order' => $schema->string()
                ->enum(['asc', 'desc'])
                ->description('Sort order')
                ->default('desc'),
        ];
    }
}
