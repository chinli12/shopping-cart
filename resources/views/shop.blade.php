<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Order with Tax Calculator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            padding: 24px;
        }

        .header {
            max-width: 1400px;
            margin: 0 auto 40px;
            padding-bottom: 24px;
            border-bottom: 1px solid #e1e4e8;
        }

        .header h1 {
            color: #0d1117;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            color: #57606a;
            font-size: 14px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 32px;
        }

        .section {
            background: white;
            border-radius: 12px;
            border: 1px solid #e1e4e8;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            color: #0d1117;
            font-size: 18px;
            font-weight: 600;
            padding: 24px 24px 0;
            margin-bottom: 20px;
        }

        .section-content {
            padding: 0 24px 24px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            margin: 0;
        }

        .product-card {
            background: white;
            border: 1px solid #e1e4e8;
            border-radius: 8px;
            padding: 16px;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            border-color: #0969da;
            box-shadow: 0 3px 12px rgba(9, 105, 218, 0.15);
            transform: translateY(-2px);
        }

        .product-name {
            font-weight: 600;
            color: #0d1117;
            margin-bottom: 8px;
            font-size: 15px;
            flex: 1;
        }

        .product-price {
            color: #0969da;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .product-stock {
            color: #57606a;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }

        .qty-input {
            flex: 0 0 60px;
            padding: 6px 8px;
            border: 1px solid #d0d7de;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        .qty-input:focus {
            outline: none;
            border-color: #0969da;
            box-shadow: 0 0 0 3px rgba(9, 105, 218, 0.1);
        }

        .add-btn {
            flex: 1;
            background: #1f6feb;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            transition: background 0.2s;
        }

        .add-btn:hover:not(:disabled) {
            background: #1860c7;
        }

        .add-btn:disabled {
            background: #d0d7de;
            cursor: not-allowed;
        }

        .cart-item {
            background: #f6f8fa;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 12px;
            border: 1px solid #e1e4e8;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: #0d1117;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .item-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #57606a;
        }

        .item-qty-input {
            width: 45px;
            padding: 4px 6px;
            border: 1px solid #d0d7de;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .item-qty-input:focus {
            outline: none;
            border-color: #0969da;
            box-shadow: 0 0 0 2px rgba(9, 105, 218, 0.1);
        }

        .item-total {
            font-weight: 600;
            color: #0969da;
        }

        .remove-btn {
            background: transparent;
            color: #d1242f;
            border: none;
            padding: 6px 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: color 0.2s;
            white-space: nowrap;
        }

        .remove-btn:hover {
            color: #a71d1f;
        }

        .summary-box {
            background: #f6f8fa;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e1e4e8;
            margin-bottom: 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .summary-row:last-child {
            margin-bottom: 0;
        }

        .summary-row label {
            color: #57606a;
            font-weight: 500;
        }

        .summary-row span {
            font-weight: 600;
            color: #0d1117;
        }

        .summary-row.total {
            border-top: 1px solid #d0d7de;
            padding-top: 10px;
            font-size: 16px;
        }

        .summary-row.total label {
            color: #0d1117;
        }

        .summary-row.total span {
            color: #1f6feb;
            font-size: 18px;
        }

        .summary-row.tax {
            color: #d1242f;
        }

        .summary-row.tax span {
            color: #d1242f;
        }

        .checkout-btn {
            background: #238636;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            transition: background 0.2s;
            margin-bottom: 8px;
        }

        .checkout-btn:hover:not(:disabled) {
            background: #1f7e34;
        }

        .checkout-btn:disabled {
            background: #d0d7de;
            cursor: not-allowed;
        }

        .clear-btn {
            background: transparent;
            color: #57606a;
            border: 1px solid #d0d7de;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s;
        }

        .clear-btn:hover {
            background: #f6f8fa;
            color: #0d1117;
            border-color: #d0d7de;
        }

        .empty-cart {
            text-align: center;
            color: #57606a;
            padding: 40px 0;
            font-size: 14px;
        }

        .empty-cart-icon {
            font-size: 40px;
            margin-bottom: 12px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 500;
            display: none;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-message {
            background: #dafbe1;
            color: #033a16;
            border: 1px solid #6fdd8b;
        }

        .error-message {
            background: #ffebe6;
            color: #82071e;
            border: 1px solid #ff8a80;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 16px;
            color: #0969da;
            font-weight: 600;
            font-size: 13px;
        }

        .spinner {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid #0969da;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin-right: 6px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .cart-count {
            display: inline-block;
            background: #d1242f;
            color: white;
            border-radius: 10px;
            width: 20px;
            height: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 6px;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 24px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 12px;
            }

            .product-card {
                padding: 12px;
            }

            .product-name {
                font-size: 13px;
            }

            .product-price {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛍️ Modern Store</h1>
        <p>Discover our products and manage your shopping cart</p>
    </div>

    <div class="container">
        <!-- Products Section -->
        <div class="section">
            <div class="section-title">Available Products</div>
            <div class="section-content">
                <div id="products-container" class="products-grid">
                    <!-- Products will be loaded here -->
                </div>
            </div>
        </div>

        <!-- Shopping Cart Section -->
        <div class="section">
            <div class="section-title">
                Shopping Cart
                <span id="cart-count" class="cart-count" style="display: none;">0</span>
            </div>
            <div class="section-content">
                <div id="success-message" class="alert success-message"></div>
                <div id="error-message" class="alert error-message"></div>
                <div id="loading" class="loading">
                    <span class="spinner"></span>Processing order...
                </div>

                <div id="cart-content">
                    <div id="cart-items-container"></div>

                    <div class="summary-box" id="summary-section" style="display: none;">
                        <div class="summary-row">
                            <label>Subtotal</label>
                            <span id="subtotal">$0.00</span>
                        </div>
                        <div class="summary-row tax">
                            <label>Tax (8%)</label>
                            <span id="tax">$0.00</span>
                        </div>
                        <div class="summary-row total">
                            <label>Total</label>
                            <span id="total">$0.00</span>
                        </div>
                    </div>

                    <button class="checkout-btn" id="checkout-btn" onclick="checkout()" disabled>
                        Proceed to Checkout
                    </button>
                    <button class="clear-btn" id="clear-btn" onclick="clearCart()">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        // Load products on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            renderCart();
            updateCartCount();
        });

        async function loadProducts() {
            try {
                const response = await fetch('/api/v1/products');
                const data = await response.json();
                
                if (data.data && Array.isArray(data.data)) {
                    renderProducts(data.data);
                } else {
                    renderSampleProducts();
                }
            } catch (error) {
                renderSampleProducts();
            }
        }

        function renderSampleProducts() {
            const sampleProducts = [
                { id: 1, name: 'Laptop Pro', price: 999.99, stock: 10 },
                { id: 2, name: 'Wireless Mouse', price: 29.99, stock: 50 },
                { id: 3, name: 'Mechanical Keyboard', price: 79.99, stock: 30 },
                { id: 4, name: '4K Monitor', price: 299.99, stock: 15 },
                { id: 5, name: 'Bluetooth Headphones', price: 149.99, stock: 25 },
                { id: 6, name: 'USB-C Hub', price: 49.99, stock: 40 }
            ];
            renderProducts(sampleProducts);
        }

        function renderProducts(products) {
            const container = document.getElementById('products-container');
            container.innerHTML = products.map(product => `
                <div class="product-card">
                    <div class="product-name">${product.name}</div>
                    <div class="product-price">$${parseFloat(product.price).toFixed(2)}</div>
                    <div class="product-stock">Stock: ${product.stock}</div>
                    <div class="product-actions">
                        <input 
                            type="number" 
                            class="qty-input" 
                            id="qty-${product.id}" 
                            value="1" 
                            min="1" 
                            max="${product.stock}"
                        >
                        <button 
                            class="add-btn" 
                            onclick="addToCart(${product.id}, '${product.name}', ${product.price}, ${product.stock})"
                            ${product.stock === 0 ? 'disabled' : ''}
                        >
                            ${product.stock === 0 ? 'Out of Stock' : 'Add'}
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function addToCart(productId, name, price, stock) {
            const qtyInput = document.getElementById(`qty-${productId}`);
            const quantity = parseInt(qtyInput.value) || 1;

            if (quantity > stock) {
                showError(`Only ${stock} items available`);
                return;
            }

            if (!cart[productId]) {
                cart[productId] = { name, price, quantity: 0 };
            }

            cart[productId].quantity += quantity;
            saveCart();
            renderCart();
            qtyInput.value = 1;

            showSuccess(`✓ ${name} added to cart`);
        }

        function removeFromCart(productId) {
            delete cart[productId];
            saveCart();
            renderCart();
        }

        function updateCart(productId, quantity) {
            if (quantity <= 0) {
                removeFromCart(productId);
            } else {
                cart[productId].quantity = parseInt(quantity);
                saveCart();
                renderCart();
            }
        }

        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function updateCartCount() {
            const cartCount = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
            const countEl = document.getElementById('cart-count');
            if (cartCount > 0) {
                countEl.textContent = cartCount;
                countEl.style.display = 'flex';
            } else {
                countEl.style.display = 'none';
            }
        }

        function renderCart() {
            const items = Object.entries(cart);
            const container = document.getElementById('cart-items-container');
            const checkoutBtn = document.getElementById('checkout-btn');
            const summarySection = document.getElementById('summary-section');

            if (items.length === 0) {
                container.innerHTML = '<div class="empty-cart"><div class="empty-cart-icon">🛒</div>Your cart is empty</div>';
                checkoutBtn.disabled = true;
                summarySection.style.display = 'none';
                updateCartCount();
                return;
            }

            checkoutBtn.disabled = false;
            summarySection.style.display = 'block';

            let subtotal = 0;
            container.innerHTML = items.map(([productId, item]) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                return `
                    <div class="cart-item">
                        <div class="item-details">
                            <div class="item-name">${item.name}</div>
                            <div class="item-meta">
                                <span>$${parseFloat(item.price).toFixed(2)}</span>
                                <span>×</span>
                                <input 
                                    type="number" 
                                    class="item-qty-input" 
                                    value="${item.quantity}" 
                                    min="1"
                                    onchange="updateCart(${productId}, this.value)"
                                >
                                <span class="item-total">= $${itemTotal.toFixed(2)}</span>
                            </div>
                        </div>
                        <button class="remove-btn" onclick="removeFromCart(${productId})">
                            ✕ Remove
                        </button>
                    </div>
                `;
            }).join('');

            updateSummary();
            updateCartCount();
        }

        function updateSummary() {
            let subtotal = 0;
            for (const item of Object.values(cart)) {
                subtotal += item.price * item.quantity;
            }

            const tax = subtotal * 0.08;
            const total = subtotal + tax;

            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('total').textContent = `$${total.toFixed(2)}`;
        }

        async function checkout() {
            const items = Object.entries(cart).map(([productId, item]) => ({
                id: parseInt(productId),
                quantity: item.quantity
            }));

            if (items.length === 0) {
                showError('Cart is empty');
                return;
            }

            document.getElementById('loading').style.display = 'block';
            document.getElementById('checkout-btn').disabled = true;

            try {
                const response = await fetch('/api/v1/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ items })
                });

                const data = await response.json();

                if (data.success) {
                    showSuccess(`✓ Order #${data.data.id} confirmed! Tax: $${parseFloat(data.data.tax).toFixed(2)}`);
                    cart = {};
                    saveCart();
                    renderCart();
                    setTimeout(() => {
                        hideMessages();
                    }, 4000);
                } else {
                    showError(data.message || 'Failed to place order');
                }
            } catch (error) {
                showError('Error: ' + error.message);
            } finally {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('checkout-btn').disabled = Object.keys(cart).length === 0;
            }
        }

        function clearCart() {
            if (Object.keys(cart).length === 0) {
                showError('Cart is already empty');
                return;
            }
            if (confirm('Clear your cart? This cannot be undone.')) {
                cart = {};
                saveCart();
                renderCart();
                showSuccess('✓ Cart cleared');
            }
        }

        function showSuccess(message) {
            const el = document.getElementById('success-message');
            if (message) {
                el.textContent = message;
                el.style.display = 'block';
                document.getElementById('error-message').style.display = 'none';
            }
        }

        function showError(message) {
            const el = document.getElementById('error-message');
            if (message) {
                el.textContent = message;
                el.style.display = 'block';
                document.getElementById('success-message').style.display = 'none';
            }
        }

        function hideMessages() {
            document.getElementById('success-message').style.display = 'none';
            document.getElementById('error-message').style.display = 'none';
        }
    </script>
</body>
</html>
