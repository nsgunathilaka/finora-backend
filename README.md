# Finora

Finora is a finance management SaaS that I'm building with Laravel and React.

The main idea is to have a single application where a company can manage its income, expenses, accounts, budgets, clients, invoices and financial reports.

I'm building this project mainly to improve my full-stack development skills and to practice building a Laravel application in a more production-oriented way.

## Tech Stack

### Backend

* PHP
* Laravel
* MySQL
* Redis
* Laravel Sanctum
* Docker

### Frontend

* React
* TypeScript
* Vite
* React Router
* Axios

The frontend and backend are separate applications and communicate through REST APIs.

---

## Current Progress

The project is currently under development.

### Backend

* [ ] Laravel project setup
* [ ] Docker environment
* [ ] MySQL and Redis setup
* [ ] API structure
* [ ] Authentication
* [ ] Organizations
* [ ] Roles and permissions
* [ ] Multi-tenancy
* [ ] Categories
* [ ] Accounts
* [ ] Income and expenses
* [ ] Dashboard
* [ ] Budgets
* [ ] Recurring transactions
* [ ] Clients
* [ ] Invoices
* [ ] Payments
* [ ] Reports
* [ ] CSV / Excel / PDF exports
* [ ] Notifications
* [ ] Queues
* [ ] Events
* [ ] Audit logs
* [ ] Caching
* [ ] Testing
* [ ] Deployment

### Frontend

The React application will be developed after the main backend APIs are ready.

* [ ] React + TypeScript setup
* [ ] Authentication
* [ ] Organization management
* [ ] Categories and accounts
* [ ] Income and expense management
* [ ] Dashboard
* [ ] Budgets
* [ ] Recurring transactions
* [ ] Clients
* [ ] Invoices
* [ ] Reports
* [ ] Notifications
* [ ] Responsive UI
* [ ] Frontend tests

---

## Main Features

### Authentication

Users will be able to:

* Register
* Login
* Logout
* Verify their email
* Reset their password

Authentication will be handled using Laravel Sanctum.

### Organizations

Finora is designed around organizations.

A user can belong to an organization, and organization members can have different roles and permissions.

The initial roles are:

* Owner
* Admin
* Accountant
* Manager
* Employee

One of the important parts of the project is making sure that users cannot access data belonging to another organization.

### Income & Expenses

Users will be able to record income and expenses and associate them with:

* Categories
* Financial accounts
* Dates
* References
* Vendors
* Payment methods
* Attachments

Transactions will also support filtering, sorting, pagination and date ranges.

### Accounts

The system will support different types of financial accounts such as:

* Cash
* Bank
* Card

### Budgets

Users can create budgets for categories and specific periods.

The application will calculate:

* Budget limit
* Amount spent
* Remaining amount
* Percentage used

Budget warnings will be triggered when spending reaches 80%, and the budget will be marked as exceeded at 100%.

### Invoices

Organizations can create invoices for their clients.

An invoice will contain:

* Client
* Line items
* Taxes
* Total
* Due date
* Payments

Invoice statuses will include:

`Draft → Sent → Viewed → Partially Paid → Paid`

Invoices can also become `Overdue` or `Cancelled`.

### Reports

The backend will provide APIs for:

* Dashboard statistics
* Income statement
* Expense reports
* Cash flow
* Monthly summaries

Reports will support date-based filtering.

### Recurring Transactions

Recurring income and expense records will be supported.

Laravel's scheduler and queues will be used to create actual transactions when they become due.

---

## API

Some of the planned API endpoints are:

```text
POST   /api/auth/register
POST   /api/auth/login
POST   /api/auth/logout
GET    /api/auth/me

GET    /api/organizations/current
PATCH  /api/organizations/current
GET    /api/organizations/members

GET    /api/transactions

POST   /api/incomes
GET    /api/incomes/{id}
PATCH  /api/incomes/{id}
DELETE /api/incomes/{id}

POST   /api/expenses
GET    /api/expenses/{id}
PATCH  /api/expenses/{id}
DELETE /api/expenses/{id}

GET    /api/budgets
POST   /api/budgets
GET    /api/budgets/{id}
PATCH  /api/budgets/{id}
DELETE /api/budgets/{id}

GET    /api/invoices
POST   /api/invoices
GET    /api/invoices/{id}
PATCH  /api/invoices/{id}

POST   /api/invoices/{id}/send
POST   /api/invoices/{id}/payments

GET    /api/reports/dashboard
GET    /api/reports/income-statement
GET    /api/reports/expenses
GET    /api/reports/cash-flow
```

The API will use JSON responses and standard HTTP methods/status codes.

---

## Database

Some of the main entities are:

```text
users
organizations
organization_users

roles
permissions

categories
accounts
transactions
incomes
expenses
attachments

budgets
budget_categories

recurring_transactions

clients
invoices
invoice_items
payments

notifications
audit_logs
```

The database structure will be developed gradually as each feature is implemented.

---

## Project Structure

The repository will contain the two applications separately:

```text
finora/
│
├── backend/
│   └── Laravel application
│
├── frontend/
│   └── React + TypeScript application
│
└── README.md
```

The backend will use Laravel's standard structure, with additional folders for services, actions, jobs, notifications, policies and API resources as the project grows.

---

## Development Approach

I'm developing this project feature by feature.

For each backend feature, the general process is:

```text
Database
   ↓
Model / Relationships
   ↓
Business Logic
   ↓
API
   ↓
Validation
   ↓
Authorization
   ↓
Tests
```

Once an API is ready, the corresponding React functionality will be connected to it.

---

## Testing

Testing will be added throughout the project rather than at the very end.

The main areas I'll cover are:

* Unit tests
* Feature tests
* API tests
* Validation tests
* Authorization tests
* Multi-tenant isolation tests
* Database tests
* Queue tests

---

## Docker

The development environment will use Docker for the main services:

```text
Laravel / PHP
MySQL
Redis
Nginx
```

The goal is to make the project easy to run on a new development environment without manually configuring every service.

---

## Deployment

After the application is completed, I plan to deploy it using:

* Docker
* Nginx
* AWS
* HTTPS
* Laravel queue workers
* Laravel scheduler
* GitHub Actions

Deployment and monitoring will be added as a later phase of the project.

---
