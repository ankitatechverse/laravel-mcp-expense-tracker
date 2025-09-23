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

### Web Testing
Visit `http://localhost:8000/test-mcp` to test MCP functionality in your browser.

## 🔧 MCP Tools

### 1. AddExpenseTool
Adds new expenses to the tracker.

**Parameters:**
- `title` (required): Expense title
- `description` (optional): Detailed description
- `amount` (required): Expense amount (decimal)
- `expense_date` (required): Date of expense (YYYY-MM-DD)
- `payment_method` (required): Payment method

**Payment Methods:**
- `cash`
- `credit_card`
- `debit_card`
- `bank_transfer`
- `digital_wallet`

### 2. GetExpensesTool
Retrieves expenses with filtering options.

**Parameters:**
- `start_date` (optional): Filter from date
- `end_date` (optional): Filter to date
- `payment_method` (optional): Filter by payment method
- `search` (optional): Search in title/description
- `limit` (optional): Maximum results (1-100)
- `sort_by` (optional): Sort field (amount, expense_date, created_at)
- `sort_order` (optional): Sort direction (asc, desc)

### 3. UpdateExpenseTool
Updates existing expenses.

**Parameters:**
- `id` (required): Expense ID to update
- `title` (optional): Updated title
- `description` (optional): Updated description
- `amount` (optional): Updated amount
- `expense_date` (optional): Updated date
- `payment_method` (optional): Updated payment method

### 4. DeleteExpenseTool
Deletes expenses by ID.

**Parameters:**
- `id` (required): Expense ID to delete

## 📊 Database Schema

### Expenses Table
```sql
- id (bigint, primary key)
- title (varchar)
- description (text, nullable)
- amount (decimal 10,2)
- expense_date (date)
- payment_method (varchar)
- created_at (timestamp)
- updated_at (timestamp)
```

## 🔍 MCP Inspector

### Start MCP Inspector
```bash
php artisan mcp:inspector mcp/expense-tracker
```

### MCP Endpoint
```
http://localhost:8000/mcp/expense-tracker
```

## 📝 API Examples

### Add an Expense
```json
{
  "jsonrpc": "2.0",
  "id": 1,
  "method": "tools/call",
  "params": {
    "name": "add_expense",
    "arguments": {
      "title": "Lunch at Restaurant",
      "description": "Business lunch with client",
      "amount": 45.50,
      "expense_date": "2024-01-15",
      "payment_method": "credit_card"
    }
  }
}
```

### Get Expenses
```json
{
  "jsonrpc": "2.0",
  "id": 2,
  "method": "tools/call",
  "params": {
    "name": "get_expenses",
    "arguments": {
      "limit": 10,
      "sort_by": "amount",
      "sort_order": "desc"
    }
  }
}
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

## 🚀 Deployment

### Production Setup
1. Set up production database
2. Configure environment variables
3. Run migrations: `php artisan migrate`
4. Set up web server (Apache/Nginx)
5. Configure MCP endpoint

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=your_production_host
DB_DATABASE=your_production_db
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Run the test suite
6. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Review the test cases for usage examples

## 🎯 Roadmap

- [ ] Add expense categories
- [ ] Implement user authentication
- [ ] Add expense reports
- [ ] Create dashboard interface
- [ ] Add data export functionality
- [ ] Implement expense budgets

---

**Built with ❤️ using Laravel and MCP**