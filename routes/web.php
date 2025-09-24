<?php

use Illuminate\Support\Facades\Route;
use App\Mcp\Servers\ExpenseServer;
use App\Mcp\Tools\AddExpenseTool;
use App\Mcp\Tools\GetExpensesTool;

Route::get('/', function () {
    return view('welcome');
});

// MCP Testing Route
Route::get('/test-mcp', function () {
    echo "<h1>🧪 MCP Expense Tracker Test</h1>";
    
    // Test Add Expense
    echo "<h2>1. Testing Add Expense</h2>";
    try {
        $response = ExpenseServer::tool(AddExpenseTool::class, [
            'title' => 'Test Lunch',
            'description' => 'Testing MCP functionality',
            'amount' => 25.50,
            'expense_date' => '2024-01-15',
            'payment_method' => 'credit_card',
        ]);
        
        echo "✅ Add Expense: SUCCESS<br>";
        echo "Response: " . json_encode($response) . "<br>";
        
    } catch (Exception $e) {
        echo "❌ Add Expense: ERROR - " . $e->getMessage() . "<br>";
    }
    
    // Test Get Expenses
    echo "<h2>2. Testing Get Expenses</h2>";
    try {
        $response = ExpenseServer::tool(GetExpensesTool::class, [
            'limit' => 5,
        ]);
        
        echo "✅ Get Expenses: SUCCESS<br>";
        echo "Response: " . json_encode($response) . "<br>";
        
    } catch (Exception $e) {
        echo "❌ Get Expenses: ERROR - " . $e->getMessage() . "<br>";
    }
    
    echo "<h2>🎉 MCP Testing Complete!</h2>";
});
