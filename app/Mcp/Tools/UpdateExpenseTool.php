<?php

namespace App\Mcp\Tools;

use App\Models\Expense;
use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class UpdateExpenseTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Update an existing expense by ID. Only provide the fields you want to update.';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:expenses,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'nullable|numeric|min:0.01',
            'expense_date' => 'nullable|date',
            'payment_method' => 'nullable|string|in:cash,credit_card,debit_card,bank_transfer,digital_wallet',
        ], [
            'id.required' => 'Expense ID is required to update an expense.',
            'id.exists' => 'The specified expense does not exist.',
            'amount.min' => 'Expense amount must be greater than 0.',
        ]);

        $expense = Expense::findOrFail($validated['id']);
        
        // Remove 'id' from the update data
        unset($validated['id']);
        
        // Only update fields that were provided
        $updateData = array_filter($validated, function ($value) {
            return $value !== null;
        });

        if (empty($updateData)) {
            return Response::error('No fields provided to update. Please specify at least one field to update.');
        }

        $expense->update($updateData);
        $expense->refresh();

        return Response::json([
            'message' => 'Expense updated successfully!',
            'expense' => [
                'id' => $expense->id,
                'title' => $expense->title,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'expense_date' => $expense->expense_date->format('Y-m-d'),
                'payment_method' => $expense->payment_method,
                'updated_at' => $expense->updated_at->format('Y-m-d H:i:s'),
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
            'id' => $schema->integer()
                ->description('The ID of the expense to update')
                ->required(),
            'title' => $schema->string()
                ->description('Updated title of the expense'),
            'description' => $schema->string()
                ->description('Updated description of the expense'),
            'amount' => $schema->number()
                ->description('Updated amount spent'),
            'expense_date' => $schema->string()
                ->description('Updated date when the expense occurred (YYYY-MM-DD)'),
            'payment_method' => $schema->string()
                ->enum(['cash', 'credit_card', 'debit_card', 'bank_transfer', 'digital_wallet'])
                ->description('Updated payment method'),
        ];
    }
}
