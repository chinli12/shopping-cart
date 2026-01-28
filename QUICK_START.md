# 🛒 Shopping Cart System - Complete Guide

## Quick Start (5 Minutes)

### Prerequisites
- PHP 8.5+
- Composer
- SQLite enabled (already configured)

### Step 1: Setup Database

```bash
cd interview-test
php artisan migrate:refresh --seed
```

This will:
- Create all tables
- Populate 8 sample products
- Create test user

### Step 2: Start Server

```bash
php artisan serve
```

Server runs on: `http://localhost:8000`

### Step 3: Open Frontend

Visit: **http://localhost:8000/shop.html**

✅ **Done!** You're ready to use the shopping cart.

---

## 📁 Project Structure

```
interview-test/
├── 🎨 Frontend
│   └── public/shop.html              Single-page application
│
├── 🔧 API
│   ├── routes/api.php                API endpoints
│   ├── app/Http/
│   │   ├── Controllers/Api/
│   │   │   └── OrderController.php   Handles requests
│   │   └── Requests/
│   │       └── StoreOrderRequest.php Validates input
│   └── app/Services/
│       └── OrderProcessingService.php Tax calculation
│
├── 💾 Models & Database
│   ├── app/Models/
│   │   ├── Product.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   └── database/
│       ├── migrations/               Database schema
│       └── seeders/
│           └── ProductSeeder.php     Sample data
│
└── 📚 Documentation
    ├── API_DOCUMENTATION.md          API endpoints
    ├── IMPLEMENTATION_SUMMARY.md     Architecture
    └── FRONTEND_README.md            Frontend guide
```

---

## 🎯 Features

### Frontend
- ✅ Product catalog with real-time inventory
- ✅ Shopping cart with add/remove items
- ✅ Automatic 8% tax calculation
- ✅ Order creation with instant confirmation
- ✅ Order history view
- ✅ Responsive design (mobile-friendly)
- ✅ No external dependencies (vanilla JS)

### Backend
- ✅ RESTful API with CRUD operations
- ✅ Request validation
- ✅ Tax calculation service
- ✅ Database transactions for data integrity
- ✅ Stock management
- ✅ Comprehensive error handling

### Database
- ✅ SQLite (configured, no setup needed)
- ✅ 3 main tables: Products, Orders, OrderItems
- ✅ Proper relationships and constraints
- ✅ Timestamps for audit trail

---

## 🔄 Data Flow

```
USER INTERACTION (shop.html)
        ↓
JAVASCRIPT (fetch API calls)
        ↓
HTTP REQUEST
    POST /api/v1/orders
        ↓
LARAVEL ROUTER
    routes/api.php
        ↓
CONTROLLER
    OrderController::store()
        ↓
REQUEST VALIDATION
    StoreOrderRequest
        ↓
BUSINESS LOGIC
    OrderProcessingService::createOrder()
    - Validates products exist
    - Checks stock
    - Calculates tax (8%)
    - Creates order with items
        ↓
MODELS & DATABASE
    Order, OrderItem, Product
        ↓
JSON RESPONSE
    {
      "success": true,
      "data": {
        "id": 1,
        "total": 324.00,
        "tax": 24.00,
        "items": [...]
      }
    }
        ↓
JAVASCRIPT PROCESSES RESPONSE
        ↓
UI UPDATES
    - Shows confirmation
    - Displays order ID
    - Updates cart display
```

---

## 📊 Tax Calculation

**Formula:** Tax = Subtotal × 8%

**Example Order:**
```
Item                    Qty  Price   Subtotal
─────────────────────────────────────────────
Laptop                  1    $999.99 $999.99
Mouse                   2    $29.99  $59.98
────────────────────────────────────────────
                               Subtotal: $1,059.97
                               Tax (8%):  $84.80
                               ──────────────────
                               Total:    $1,144.77
```

---

## 🧪 Testing the API

### Test 1: Create an Order

```bash
curl -X POST http://localhost:8000/api/v1/orders \
  -H "Content-Type: application/json" \
  -d '{
    "items": [
      {"product_id": 1, "quantity": 1},
      {"product_id": 2, "quantity": 2}
    ]
  }'
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 1,
    "total": "1059.97",
    "tax": "79.98",
    "status": "pending",
    "items": [...]
  }
}
```

### Test 2: Get Order Details

```bash
curl http://localhost:8000/api/v1/orders/1
```

### Test 3: List All Orders

```bash
curl http://localhost:8000/api/v1/orders
```

### Test 4: Health Check

```bash
curl http://localhost:8000/api/health
```

---

## 🛠️ Configuration

### Change Tax Rate

**Option 1: Frontend Only** (client-side calculation only)
Edit `public/shop.html`, line ~420:
```javascript
const tax = subtotal * 0.10; // Change 0.08 to 0.10 for 10%
```

**Option 2: Backend & Frontend** (recommended)

1. Update `app/Services/OrderProcessingService.php`:
```php
$tax = $subtotal * 0.10; // Change tax rate
```

2. Update `public/shop.html`:
```javascript
const tax = subtotal * 0.10; // Same rate as backend
```

### Add More Products

Edit `database/seeders/ProductSeeder.php`:

```php
$products = [
    // ... existing products ...
    [
        'name' => 'USB Hub',
        'description' => '7-port USB hub',
        'price' => 39.99,
        'stock' => 40,
    ],
];
```

Then re-seed:
```bash
php artisan db:seed --class=ProductSeeder
```

---

## 🐛 Troubleshooting

### "Cannot find shop.html"
- Make sure server is running on `localhost:8000`
- Visit: `http://localhost:8000/shop.html`

### "API Offline" error
- Server might have crashed
- Run: `php artisan serve`
- Verify port 8000 is available

### "Product not found" error
- Database not seeded
- Run: `php artisan db:seed`

### "Insufficient stock" error
- Product inventory is low
- Check stock in database or reset: `php artisan migrate:refresh --seed`

### JavaScript console errors
- Open browser DevTools (F12)
- Check Console tab for errors
- Verify API URL is correct

---

## 📱 Frontend Usage

### Adding Items
1. Select quantity from input
2. Click "Add" button
3. Item appears in cart
4. Totals update automatically

### Viewing Orders
1. Click "My Orders" tab
2. See all past orders
3. Order ID, total, and tax shown
4. Click "Refresh Orders" to reload

### Checkout
1. Review cart totals
2. Click "Checkout"
3. See order confirmation
4. Order ID displayed
5. Cart automatically clears

---

## 🔒 Security Features

- ✅ Input validation on form request
- ✅ Database transactions prevent partial orders
- ✅ Stock locking prevents overselling
- ✅ Error handling doesn't expose internals
- ✅ API runs on separate route (not directly accessible)

---

## 📈 Performance Notes

- Single HTML file: < 20KB
- No external dependencies
- CSS-in-JS: instant render
- Minimal API calls
- SQLite: lightweight, file-based
- Mobile optimized

---

## 🎓 Learning Points

This project demonstrates:

1. **Service Layer Architecture** - Business logic separated from controllers
2. **Dependency Injection** - Service injected into controller
3. **Form Validation** - StoreOrderRequest validates data
4. **Database Transactions** - Ensures data consistency
5. **RESTful API Design** - Proper HTTP methods and status codes
6. **Eloquent Relationships** - Proper model relationships
7. **Tax Calculation** - Realistic ecommerce feature
8. **Frontend-Backend Integration** - Proper API communication

---

## 📝 API Endpoints Summary

| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/api/v1/orders` | List all orders (paginated) |
| POST | `/api/v1/orders` | Create new order |
| GET | `/api/v1/orders/{id}` | Get order details |
| GET | `/health` | API health status |

---

## 🚀 Next Steps

1. ✅ Test the frontend at `http://localhost:8000/shop.html`
2. ✅ Create an order and see tax calculation
3. ✅ View order history
4. ✅ Experiment with API endpoints
5. ✅ Customize products and tax rate
6. ✅ Deploy to production (requires web server)

---

## 📚 Documentation Files

- **API_DOCUMENTATION.md** - Complete API reference
- **IMPLEMENTATION_SUMMARY.md** - Technical architecture
- **FRONTEND_README.md** - Frontend usage guide

---

## 💡 Tips

- Use browser DevTools to inspect network calls
- Check Laravel logs in `storage/logs/`
- Use `php artisan tinker` to test models
- Run `php artisan migrate:status` to see migrations

---

## 🎉 You're All Set!

The shopping cart system is fully functional with:
- ✅ Frontend UI (no dependencies)
- ✅ Backend API (Laravel)
- ✅ Database (SQLite)
- ✅ Tax calculation (8%)
- ✅ Order management
- ✅ Product inventory

**Start shopping now!** 🛍️
