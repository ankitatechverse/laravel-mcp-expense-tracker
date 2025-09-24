# 🧾 Laravel MCP Expense Tracker

A comprehensive expense tracking system built with Laravel and Model Context Protocol (MCP). This project demonstrates how to create MCP servers for AI-powered expense management.

## 🚀 Features

### Core Functionality
- ✅ **Add Expenses** - Create new expense records
- ✅ **Get Expenses** - Retrieve and filter expenses
- ✅ **Update Expenses** - Modify existing expense records
- ✅ **Delete Expenses** - Remove expense records
- ✅ **Advanced Filtering** - Filter by date range, payment method, search terms
- ✅ **Summary Statistics** - Total amounts, counts, and averages

### MCP Integration
- 🤖 **AI-Powered** - Designed for AI assistant integration
- 🔧 **MCP Tools** - Four comprehensive MCP tools
- 📊 **JSON Responses** - Structured data for AI consumption
- ✅ **Validation** - Robust input validation and error handling

## 🛠️ Technology Stack

- **Backend**: Laravel 12
- **Database**: MySQL/SQLite
- **Testing**: Pest PHP
- **MCP**: Laravel MCP Package
- **Code Quality**: Laravel Pint

## 📋 Requirements

- PHP 8.4+
- Composer
- MySQL or SQLite
- Node.js (for MCP Inspector)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/mcp-expense-tracker.git
cd mcp-expense-tracker
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Update your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Start the Server
```bash
php artisan serve
```

## 🧪 Testing

### Run All Tests
```bash
php artisan test
```

### Run MCP Tests
```bash
php artisan test tests/Feature/ExpenseTrackerMcpTest.php
```

## 🤖 Testing with AI Assistants

### Cursor IDE (Recommended) ✅

**Step 1: Configure MCP Server**
Create `.cursor/mcp.json` in your project root:
```json
{
  "mcpServers": {
    "expense-tracker": {
      "command": "php",
      "args": [
        "artisan",
        "mcp:start",
        "expense-tracker"
      ],
      "cwd": "."
    }
  }
}
```

**Step 2: Restart Cursor IDE**
- Close and reopen Cursor IDE
- Check MCP panel for "expense-tracker" server (should show green status)

**Step 3: Test Commands**
In Cursor chat, try these commands:
```
Add a 450 rupee grocery expense paid with debit card today
Show me all expenses from this month
Find all credit card expenses over 500 rupees
Update expense ID 5 to 475 rupees
Delete expense ID 3
```

**Expected Result:** Cursor will use your MCP tools directly to interact with your expense tracker.

### MCP Inspector (Limited Support) ⚠️

**Known Issues & Solutions:**

**Issue 1: Path Separator Problems (Windows)**
```bash
Error: Could not open input file: D:projectsuserlaravelmcp-demoartisan
```
**Root Cause:** MCP Inspector uses forward slashes (`D:/projects/user/...`) but Windows expects backslashes (`D:\projects\user\...`)

**Issue 2: SSE Connection Errors**
```bash
Error: Error POSTing to endpoint (HTTP 500): SSE connection not established
```
**Root Cause:** Server-Sent Events connection fails between MCP Inspector and local MCP servers

**Issue 3: Command Spawn Errors**
```bash
Error: spawn mcp-server-everything ENOENT
```
**Root Cause:** MCP Inspector tries to spawn non-existent commands

**Why It Works in Cursor but Not Inspector:**
- ✅ **Cursor IDE**: Uses proper Windows path handling and direct MCP integration
- ❌ **MCP Inspector**: Has cross-platform compatibility issues, especially on Windows

**My Testing Experience:**

I tested this MCP server in both **Cursor IDE** and **MCP Inspector**:

- ✅ **Cursor IDE**: Works perfectly! All MCP tools function correctly
- ❌ **MCP Inspector**: Encountered various connection errors when clicking "Connect"

## 🎯 Quick Test Commands

### For Cursor IDE:
```
"Add a 100 rupee expense for snacks paid with cash today"
"Show me all my expenses"
"Find expenses paid with credit card"
"Update expense ID 2 to have amount 10 rupees"
"Delete expense ID 3"
```

## 🏗️ Project Structure

```
app/
├── Mcp/
│   ├── Servers/
│   │   └── ExpenseServer.php
│   └── Tools/
│       ├── AddExpenseTool.php
│       ├── GetExpensesTool.php
│       ├── UpdateExpenseTool.php
│       └── DeleteExpenseTool.php
├── Models/
│   └── Expense.php
database/
├── factories/
│   └── ExpenseFactory.php
├── migrations/
│   └── create_expenses_table.php
└── seeders/
    └── ExpenseSeeder.php
tests/
└── Feature/
    └── ExpenseTrackerMcpTest.php
routes/
├── web.php
└── ai.php
```

## 🧪 Testing Coverage

- ✅ **CRUD Operations** - All create, read, update, delete operations
- ✅ **Validation** - Input validation and error handling
- ✅ **Filtering** - Date range, payment method, search filtering
- ✅ **Edge Cases** - Invalid IDs, missing fields, boundary conditions
- ✅ **Database** - Database assertions and data integrity

---

**Built with ❤️ using Laravel and MCP**