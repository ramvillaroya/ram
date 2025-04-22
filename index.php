<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}


$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STREETWEAR</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f9;
            color: black;
        }
        .top-nav {
            background-color: #232f3e;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-nav h1 {
            font-size: 24px;
        }
        .search-bar {
            flex-grow: 1;
            margin: 0 20px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 50%;
        }
        .cart-icon {
            width: 40px;
            cursor: pointer;
        }
        .drawer {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #232f3e;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 60px;
            z-index: 1000;
        }
        .drawer a {
            padding: 12px 12px 12px 32px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .drawer a:hover {
            background-color: #575757;
        }
        .drawer .close-btn {
            position: absolute;
            top: 0;
            left: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        .open-drawer-btn {
            background: #232f3e;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .banner {
            width: 100%;
            height: 400px;
            background: url('wear.jpg') no-repeat center center/cover;
        }
        .category-bar {
            background-color: #232f3e;
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-around;
        }
        .category-item {
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
        }
        .category-item:hover {
            background-color: #1d2c3a;
        }
        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            background: white;
        }
        .product-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #ddd;
            transition: transform 0.3s ease-in-out;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .button-group {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }
        .add-to-cart, .buy-now {
            background: #232f3e;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            flex: 1;
            margin: 0 5px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .pagination button {
            background-color: #fff;
            border: none;
            padding: 10px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .pagination button:hover {
            background-color: #000;
            color: #fff;
        }
        .cart-container {
            padding: 20px;
            background: white;
            margin: 20px;
            border-radius: 10px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .cart-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .cart-item button {
            background-color: #c0392b;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .cart-item button:hover {
            background-color: #e74c3c;
        }
        footer {
            background-color: #232f3e;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .drawer-content {
            margin-top: 10px;
        }
        .image-gallery {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            gap: 10px;
        }
        .image-gallery img {
            width: 30%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding-top: 50px;
        }

        h1 {
            color: #00D1C1;
        }

        .user-info {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .links {
            margin-top: 20px;
        }

        .links a {
            padding: 10px;
            color: #fff;
            background-color: #00D1C1;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .links a:hover {
            background-color: #00b3a9;
        }

        .logout {
            padding: 10px;
            color: white;
            background-color: #ff5e57;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout:hover {
            background-color: #e14e43;
        }
    </style>
</head>
<body>

<header class="top-nav">
    <h1>STREETWEAR</h1>
    <input type="text" class="search-bar" placeholder="Search for products...">
    <img src="cart.png" alt="Cart" class="cart-icon" onclick="viewCart()">
    <button class="open-drawer-btn" onclick="openDrawer()">☰</button>
</header>

<div class="container">
    <div class="user-info">
        <h1>Welcome, <?= htmlspecialchars($user["firstname"]) ?>!</h1>
        <p>Your email: <?= htmlspecialchars($user["email"]) ?></p>
    </div>

    <div class="links">
        <a href="profile.php">View Profile</a>
        <a href="shop.php">Shop Now</a>
        <a href="cart.php">View Cart</a>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<div id="myDrawer" class="drawer">
    <a href="javascript:void(0)" class="close-btn" onclick="closeDrawer()">×</a>
    <div class="drawer-content">
        <a href="#">User Profile</a>
        <a href="#">Terms and Conditions</a>
        <a href="#">About</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="image-gallery">
    <img src="image/71KC6JnJeFL._AC_UL1500_.jpg" alt="Streetwear Image 1">
    <img src="image/th (1).jpeg" alt="Streetwear Image 2">
    <img src="image/th.jpeg" alt="Streetwear Image 3">
</div>

<div class="banner"></div>

<div class="category-bar">
    <div class="category-item" onclick="filterProducts('all')">All</div>
    <div class="category-item" onclick="filterProducts('men')">Men</div>
    <div class="category-item" onclick="filterProducts('women')">Women</div>
    <div class="category-item" onclick="filterProducts('Kids')">Kids</div>
</div>

<section class="product-container" id="product-container">
    <!-- Products will be dynamically inserted here -->
</section>

<div class="pagination">
    <button onclick="changePage(1)">1</button>
    <button onclick="changePage(2)">2</button>
    <button onclick="changePage(3)">3</button>
</div>

<section class="cart-container" id="cart-container" style="display:none;">
   
    <div id="cart-items"></div>
    <button onclick="checkout()">Checkout</button>
</section>

<footer>
    <p>© 2025 STREETWEAR. All Rights Reserved.</p>
</footer>

<script>
// JavaScript code for product management, cart, drawer and other interactions...
</script>

</body>
</html>
