# Laravel Order Processing System (High-Concurrency Demo)

## Overview
This repository demonstrates a robust, ACID-compliant order processing system designed for high-accuracy environments (e.g., Healthcare or Fintech). 

It implements the **Service-Repository pattern** to decouple business logic from the HTTP layer, ensuring the order processing logic is reusable across different interfaces (API, Web, CLI).

**Key Features:**
* **Concurrency Control:** Uses `lockForUpdate()` (Pessimistic Locking) to prevent race conditions during high-traffic inventory deduction.
* **Data Integrity:** Full Database Transactions ensure that order creation, stock deduction, and line-item generation strictly succeed or fail together.
* **Validation:** FormRequests separate validation rules from controller logic.
* **Frontend:** A reactive vanilla JS frontend interacting with the API.

## Architecture Decisions

### 1. Pessimistic Locking (`lockForUpdate`)
In a medical supply or financial context, "eventual consistency" is often unacceptable. I chose pessimistic locking over optimistic locking to guarantee that inventory is strictly reserved at the moment of processing. This prevents the "overselling" scenario where two users purchase the last unit simultaneously.

### 2. Service Layer
The `OrderProcessingService` handles the raw business logic. This allows us to:
* Unit test the logic without mocking HTTP requests.
* Trigger orders from background jobs (Queues) or CLI commands without code duplication.

### 3. Dependency Injection
Dependencies (like the Service) are injected into the Controller. In a production environment, this allows us to easily swap implementations (e.g., swapping `OrderProcessingService` for `MockOrderService` during Feature Tests).

## Installation & Setup

This demo is designed to run with **SQLite** for zero-dependency testing.

1. **Clone & Install Dependencies**
   ```bash
   composer install
