<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user'])) {
    header("Location: cart.php");
    exit;
}

$user = $_SESSION['user'];
$query = "SELECT id, product_name, product_price, image_path FROM cart_items WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $total += floatval($row['product_price']);
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modern Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 40px;
        }
        .checkout-container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            gap: 20px;
        }
        .left, .right {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        }
        .left { flex: 2; }
        .right { flex: 1; }

        /* Product List */
        .product {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }
        .product img {
            width: 80px;
            border-radius: 8px;
            margin-right: 16px;
        }
        .product-info {
            flex: 1;
        }
        .product-name {
            font-weight: 600;
            margin-bottom: 4px;
        }
        .product-price {
            color: #e63946;
            font-weight: bold;
        }
        .product-old-price {
            text-decoration: line-through;
            color: #999;
            margin-left: 8px;
        }
        .quantity-selector {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
    width: 100px;
}

.qty-btn {
    width: 30px;
    height: 32px;
    background: #f0f0f0;
    border: none;
    cursor: pointer;
    font-size: 18px;
}

.quantity-selector input {
    width: 40px;
    text-align: center;
    border: none;
    background: white;
    font-size: 16px;
}

.remove-btn {
    background: none;
    border: none;
    color: #ff4d4d;
    font-size: 18px;
    margin-left: 10px;
    cursor: pointer;
}


        /* Delivery and Addon */
        .section {
            margin-top: 40px;
        }
        .section h3 {
            margin-bottom: 12px;
        }
        .option-box {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .option-box input[type="radio"],
        .option-box input[type="checkbox"] {
            transform: scale(1.3);
        }

        /* Payment Summary */
        .summary-box {
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .summary-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-total {
            font-weight: bold;
            font-size: 18px;
            color: #111;
        }
        button {
            width: 100%;
            padding: 14px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <!-- LEFT SIDE -->
    <div class="left">
        <h2>Order</h2>
        <?php foreach ($cartItems as $item): ?>
            <div class="product">
                <img src="<?= $item['image_path'] ?>" alt="Product">
                <div class="product-info">
                    <div class="product-name"><?= htmlspecialchars($item['product_name']) ?></div>
                    <div>
                        <span class="product-price">₱<?= number_format($item['product_price'], 2) ?></span>
                        <span class="product-old-price">₱<?= number_format($item['product_price'] * 1.2, 2) ?></span>
                    </div>
                    <div class="quantity-select">
                        Quantity:
                        <select><option>1</option><option>2</option><option>3</option></select>
                    </div>
                </div>
                <div class="sale-ribbon">SALE TIME!</div>
            </div>
        <?php endforeach; ?>

        <!-- Delivery -->
        <div class="section">
            <h3>Delivery</h3>
            <div class="option-box"><span>DPD Deliveries</span><span>₱5.25</span><input type="radio" name="delivery" checked></div>
            <div class="option-box"><span>UPS Deliveries</span><span>₱5.50</span><input type="radio" name="delivery"></div>
            <div class="option-box"><span>FedEx Fast</span><span>₱7.25</span><input type="radio" name="delivery"></div>
        </div>

        <!-- Additional Services -->
        <div class="section">
            <h3>Additional Services</h3>
            <div class="option-box"><span>Care+ Package</span><span>₱10.00</span><input type="checkbox" class="addon" data-price="10"></div>
            <div class="option-box"><span>Environment Friendly</span><span>₱2.00</span><input type="checkbox" class="addon" data-price="2"></div>
            <div class="option-box"><span>Golden Guard</span><span>₱5.00</span><input type="checkbox" class="addon" data-price="5"></div>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <h2>Payment Summary</h2>
        <p><strong>UNREGISTERED ACCOUNT</strong></p>
        <p>Transaction Code: <strong>VC115665</strong></p>
        <input type="text" placeholder="COUPON CODE">
        <button style="background:#ddd; color:#333; margin: 10px 0;">Apply</button>

        <div class="summary-box">
            <div class="summary-line">
                <span>Order Summary:</span>
                <span id="order-total">₱<?= number_format($total, 2) ?></span>
            </div>
            <div class="summary-line">
                <span>Additional Service:</span>
                <span id="addon-total">₱0.00</span>
            </div>
            <div class="summary-line summary-total">
                <span>Total Amount:</span>
                <span id="total-amount">₱<?= number_format($total, 2) ?></span>
            </div>
        </div>

        <p style="color: #e63946; font-weight: bold; margin-top: 12px;">SALE EXPIRING IN: <span id="sale-timer">21 HOURS, 31 MINUTES</span></p>
        <button>Proceed to Payment</button>
    </div>
</div>

<script>
    const addons = document.querySelectorAll('.addon');
    addons.forEach(addon => addon.addEventListener('change', updateTotal));

    function updateTotal() {
        let addonTotal = 0;
        addons.forEach(addon => {
            if (addon.checked) {
                addonTotal += parseFloat(addon.dataset.price);
            }
        });
        const baseTotal = <?= $total ?>;
        document.getElementById("addon-total").textContent = `₱${addonTotal.toFixed(2)}`;
        document.getElementById("total-amount").textContent = `₱${(baseTotal + addonTotal).toFixed(2)}`;
    }
</script>

</body>
</html>
