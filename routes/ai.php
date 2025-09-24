<?php

use Laravel\Mcp\Facades\Mcp;

// Mcp::web('/mcp/demo', \App\Mcp\Servers\PublicServer::class);

// Mcp::web('/mcp/expense-tracker', \App\Mcp\Servers\ExpenseServer::class);

Mcp::local('expense-tracker', \App\Mcp\Servers\ExpenseServer::class);
