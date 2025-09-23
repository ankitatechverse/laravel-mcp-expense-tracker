<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;
use App\Mcp\Tools\AddExpenseTool;
use App\Mcp\Tools\GetExpensesTool;
use App\Mcp\Tools\UpdateExpenseTool;
use App\Mcp\Tools\DeleteExpenseTool;   
class ExpenseServer extends Server
{
    /**
     * The MCP server's name.
     */
    protected string $name = 'Expense Server';

    /**
     * The MCP server's version.
     */
    protected string $version = '1.0.0';

    /**
     * The MCP server's instructions for the LLM.
     */
    protected string $instructions = 'You are a simple expense tracking assistant. You can help users add new expenses, retrieve and filter existing expenses, update expense details, and delete expenses. Always provide clear feedback and helpful suggestions.';

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Tool>>
     */
    protected array $tools = [
        AddExpenseTool::class,
        GetExpensesTool::class,
        UpdateExpenseTool::class,
        DeleteExpenseTool::class,
    ];

    /**
     * The resources registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Resource>>
     */
    protected array $resources = [
        //
    ];

    /**
     * The prompts registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Prompt>>
     */
    protected array $prompts = [
        //
    ];
}
