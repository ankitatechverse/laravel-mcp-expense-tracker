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

### Test Specific Functionality
```bash
# Test adding expenses
php artisan test --filter="add expense"

# Test getting expenses
php artisan test --filter="get expenses"

# Test updating expenses
php artisan test --filter="update expense"

# Test deleting expenses
php artisan test --filter="delete expense"
```

## 🔧 MCP Tools

- **AddExpenseTool** - Add new expenses with title, description, amount, date, and payment method
- **GetExpensesTool** - Retrieve expenses with filtering by date, payment method, and search
- **UpdateExpenseTool** - Update existing expenses by ID
- **DeleteExpenseTool** - Delete expenses by ID

## 🔍 MCP Inspector

### Start MCP Inspector
```bash
php artisan mcp:inspector mcp/expense-tracker
```

### MCP Endpoint
```
http://localhost:8000/mcp/expense-tracker
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