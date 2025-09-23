<?php

use App\Mcp\Servers\ExpenseServer;
use App\Mcp\Tools\AddExpenseTool;
use App\Mcp\Tools\GetExpensesTool;
use App\Mcp\Tools\UpdateExpenseTool;
use App\Mcp\Tools\DeleteExpenseTool;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // No user authentication needed for simplified expense tracker
});

test('can add expense using add expense tool', function () {
    $response = ExpenseServer::tool(AddExpenseTool::class, [
        'title' => 'Lunch at Restaurant',
        'description' => 'Business lunch with client',
        'amount' => 45.50,
        'expense_date' => '2024-01-15',
        'payment_method' => 'credit_card',
    ]);

    $response->assertOk();
    $response->assertSee('Expense added successfully!');
    
    $this->assertDatabaseHas('expenses', [
        'title' => 'Lunch at Restaurant',
        'amount' => 45.50,
    ]);
});

test('can get expenses using get expenses tool', function () {
    Expense::factory()->count(3)->create();
    
    $response = ExpenseServer::tool(GetExpensesTool::class, [
        'limit' => 10,
        'sort_by' => 'amount',
        'sort_order' => 'desc',
    ]);

    $response->assertOk();
    $response->assertSee('expenses');
    $response->assertSee('summary');
});

test('can filter expenses by payment method', function () {
    Expense::factory()->create(['payment_method' => 'credit_card']);
    Expense::factory()->create(['payment_method' => 'cash']);
    
    $response = ExpenseServer::tool(GetExpensesTool::class, [
        'payment_method' => 'credit_card',
    ]);

    $response->assertOk();
    $response->assertSee('credit_card');
});

test('can update expense using update expense tool', function () {
    $expense = Expense::factory()->create();
    
    $response = ExpenseServer::tool(UpdateExpenseTool::class, [
        'id' => $expense->id,
        'title' => 'Updated Title',
        'amount' => 99.99,
    ]);

    $response->assertOk();
    $response->assertSee('Expense updated successfully!');
    
    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id,
        'title' => 'Updated Title',
        'amount' => 99.99,
    ]);
});

test('can delete expense using delete expense tool', function () {
    $expense = Expense::factory()->create();
    
    $response = ExpenseServer::tool(DeleteExpenseTool::class, [
        'id' => $expense->id,
    ]);

    $response->assertOk();
    $response->assertSee('Expense deleted successfully!');
    
    $this->assertDatabaseMissing('expenses', [
        'id' => $expense->id,
    ]);
});

test('add expense tool validates required fields', function () {
    $response = ExpenseServer::tool(AddExpenseTool::class, [
        'title' => 'Test Expense',
        // Missing required fields
    ]);

    $response->assertHasErrors();
});

test('update expense tool validates expense exists', function () {
    $response = ExpenseServer::tool(UpdateExpenseTool::class, [
        'id' => 99999, // Non-existent ID
        'title' => 'Updated Title',
    ]);

    $response->assertHasErrors();
});

test('delete expense tool validates expense exists', function () {
    $response = ExpenseServer::tool(DeleteExpenseTool::class, [
        'id' => 99999, // Non-existent ID
    ]);

    $response->assertHasErrors();
});

test('get expenses tool provides summary statistics', function () {
    Expense::factory()->create(['amount' => 100]);
    Expense::factory()->create(['amount' => 200]);
    
    $response = ExpenseServer::tool(GetExpensesTool::class, []);

    $response->assertOk();
    $response->assertSee('total_count');
    $response->assertSee('total_amount');
    $response->assertSee('average_amount');
});
