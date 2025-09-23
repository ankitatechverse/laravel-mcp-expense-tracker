<?php

namespace App\Mcp\Tools;

use App\Models\Expense;
use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class DeleteExpenseTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Delete an expense by ID. This action cannot be undone.';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:expenses,id',
        ], [
            'id.required' => 'Expense ID is required to delete an expense.',
            'id.exists' => 'The specified expense does not exist.',
        ]);

        $expense = Expense::findOrFail($validated['id']);
        
        // Store expense details before deletion for confirmation
        $expenseDetails = [
            'id' => $expense->id,
            'title' => $expense->title,
            'amount' => $expense->amount,
            'expense_date' => $expense->expense_date->format('Y-m-d'),
        ];
        
        $expense->delete();

        return Response::json([
            'message' => 'Expense deleted successfully!',
            'deleted_expense' => $expenseDetails,
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
                ->description('The ID of the expense to delete')
                ->required(),
        ];
    }
}
