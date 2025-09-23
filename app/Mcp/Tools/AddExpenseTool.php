<?php

namespace App\Mcp\Tools;

use App\Models\Expense;
use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class AddExpenseTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Add a new expense to the tracker with title, description, amount, date, and payment method.';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,credit_card,debit_card,bank_transfer,digital_wallet',
        ], [
            'title.required' => 'Expense title is required. Please provide a descriptive title for your expense.',
            'amount.required' => 'Expense amount is required. Please specify how much you spent.',
            'amount.min' => 'Expense amount must be greater than 0.',
            'expense_date.required' => 'Expense date is required. Please specify when the expense occurred.',
            'payment_method.required' => 'Payment method is required. Choose from: cash, credit_card, debit_card, bank_transfer, digital_wallet.',
        ]);

        $expense = Expense::create($validated);

        return Response::json([
            'message' => 'Expense added successfully!',
            'expense' => [
                'id' => $expense->id,
                'title' => $expense->title,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'expense_date' => $expense->expense_date->format('Y-m-d'),
                'payment_method' => $expense->payment_method,
                'created_at' => $expense->created_at->format('Y-m-d H:i:s'),
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
            'title' => $schema->string()
                ->description('The title of the expense (e.g., "Lunch at Restaurant")')
                ->required(),
            'description' => $schema->string()
                ->description('Optional detailed description of the expense')
                ->nullable(),
            'amount' => $schema->number()
                ->description('The amount spent (must be greater than 0)')
                ->required(),
            'expense_date' => $schema->string()
                ->format('date')
                ->description('The date when the expense occurred (YYYY-MM-DD)')
                ->required(),
            'payment_method' => $schema->string()
                ->enum(['cash', 'credit_card', 'debit_card', 'bank_transfer', 'digital_wallet'])
                ->description('How the expense was paid')
                ->required(),
        ];
    }
}
