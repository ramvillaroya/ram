<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: dashboard.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f9;
            color: black;
            padding-top: 8px;
        }

        .top-nav {
            background-color: #232f3e;
            color: white;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-nav h1 { font-size: 24px; }
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
            width: 0;
            overflow-x: hidden;
            background-color: #241d66;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            color: white;
            font-family: Arial, sans-serif;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
            transition: width 0.3s;
        }
        .user-menu {
    position: relative;
    display: inline-block;
}

.user-icon {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: white;
}

.user-icon:hover {
    color: #ddd;
}

.username {
    font-weight: bold;
    font-size: 14px;
}

.user-dropdown {
    display: none;
    position: absolute;
    right: 0;
    background-color: white;
    color: #232f3e;
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    border-radius: 8px;
    z-index: 1000;
    padding: 10px 0;
    top: 40px;
}

.user-dropdown a {
    padding: 10px 20px;
    display: block;
    text-decoration: none;
    color: #232f3e;
    transition: background 0.3s;
}

.user-dropdown a:hover {
    background-color: #f1f1f1;
}


        .nav-link {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background 0.3s;
        }

        .nav-link:hover {
            background-color: #312c89;
        }

        .nav-link.active {
            background-color: white;
            color: #241d66;
            font-weight: bold;
        }

        .close-btn {
            color: white;
            font-size: 24px;
            position: absolute;
            top: 15px;
            right: 20px;
            text-decoration: none;
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
            gap: 10px;
            padding: 10px;
            background: white;
        }

        .product-card {
            background: white;
            padding: 10px;
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

        .add-to-cart,
        .buy-now {
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
        .cart-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 40px;
    background-color: white;
    color: #232f3e;
    min-width: 250px;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    border-radius: 10px;
    z-index: 1000;
    padding: 10px;
}


        .cart-container {
            padding: 20px;
            background: white;
            margin: 20px auto;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            display: none;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .cart-item button {
            background-color: #c0392b;
            color: white;
            border: none;
            padding: 8px 10px;
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

        .image-gallery {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px;
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
            padding-top: 10px;
        }

        h1 {
            color: #00D1C1;
        }

        .user-info {
            background-color: #ffffff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
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


<!-- 🧑 User Profile Dropdown in the Top Nav -->
<!-- Inside your header .top-nav -->
<header class="top-nav">
    <h1>STREETWEAR</h1>
    <input type="text" class="search-bar" placeholder="Search for products...">
    <div class="cart-menu" onclick="toggleCartMenu()" style="position: relative; cursor: pointer;">
    <img src="image/cart_shop_white-removebg-preview.png" alt="Cart" class="cart-icon">
    <!-- Dropdown content -->
    <div id="cartDropdown" class="cart-dropdown">
        <div id="cart-items">
        </div>
    </div>
</div>

    <!-- 👇 Add user menu here -->
    <div class="user-menu">
        <div class="user-icon" onclick="toggleUserMenu()">
            <i class="fas fa-user-circle fa-2x"></i>
            
        </div>
        <div id="userDropdown" class="user-dropdown">
            <a href="#"><i class="fas fa-home"></i> Dashboard</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
        </div>
    </div>
</header>
<div class="container">
    <div class="user-info">
        <h1>Welcome, <?= htmlspecialchars($user["firstname"]) ?>!</h1>
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

<section class="product-container" id="product-container"></section>

<div class="pagination">
    <button onclick="changePage(1)">1</button>
    <button onclick="changePage(2)">2</button>
    <button onclick="changePage(3)">3</button>
</div>


<footer>
    <p>© 2025 STREETWEAR. All Rights Reserved.</p>
</footer>

<script>
    const products = [
        { name: 'New Balance Fresh Foam X', price: 2995, category: 'men', image: 'image/new balance.jpg' },
        { name: 'Nike Ultraboost', price: 4995, category: 'women', image: 'image/nike1.avif' },
        { name: 'Nike Air Max', price: 2995, category: 'Kids', image: 'image/kids1.jpeg' },
        { name: 'New Balance Journey Run', price: 1999, category: 'Kids', image: 'image/price 1.jpg' },
        { name: 'Nike Dunk Low Retro', price: 2350, category: 'men', image: 'image/nike dunk.jpeg' },
        { name: 'Nike LeBron NXXT', price: 4470, category: 'men', image: 'image/lebron.jpeg' },
        { name: 'Nike Sabrina 2', price: 2499, category: 'women', image: 'image/sabrina.png' },
        { name: 'Nike Air Force 1', price: 1899, category: 'women', image: 'image/air force 1.jpeg' },
        { name: 'Nike Air Force 1 White', price: 3899, category: 'Kids', image: 'image/air force 1 white.jpeg' },
        { name: 'Nike Air Force 1 Low', price: 1690, category: 'Kids', image: 'image/low air force.jpeg' },
        { name: 'Nike Air Force 1 Low', price: 3740, category: 'Kids', image: 'image/th (2).jpeg' },
        { name: 'Nike Air Force 1 Millenium', price: 3699, category: 'Kids', image: 'image/millenium.jpeg' },
    ];

    let cart = [];
    let currentPage = 1;
    let currentCategory = 'all';

    function loadProducts(page = 1, category = 'all') {
        currentCategory = category;
        const startIndex = (page - 1) * 4;
        const filtered = category === 'all' ? products : products.filter(p => p.category === category);
        const displayed = filtered.slice(startIndex, startIndex + 4);
        const container = document.getElementById('product-container');
        container.innerHTML = '';

        displayed.forEach(product => {
            container.innerHTML += `
                <div class="product-card">
                    <img src="${product.image}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p>₱${product.price}</p>
                    <div class="button-group">
                        <div class="add-to-cart" onclick="addToCart('${product.name}', ${product.price})">Add to Cart</div>
                        <div class="buy-now" onclick="buyNow('${product.name}', ${product.price})">Buy Now</div>
                    </div>
                </div>
            `;
        });
    }

    function addToCart(name, price) {
        cart.push({ name, price });
        alert(`${name} has been added to your cart!`);
        updateCartDropdown();
    }

    function updateCartDropdown() {
        const container = document.getElementById('cart-items');
        container.innerHTML = '';

        cart.forEach((item, index) => {
            container.innerHTML += `
                <div class="cart-item">
                    <span>${item.name} - ₱${item.price}</span>
                    <button onclick="removeFromCart(${index})">Remove</button>
                </div>
            `;
        });
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCartDropdown();
    }

    function buyNow(name, price) {
        alert(`Buying ${name} for ₱${price}`);
    }

    function filterProducts(category) {
        currentPage = 1;
        loadProducts(currentPage, category);
    }

    function changePage(page) {
        currentPage = page;
        loadProducts(page, currentCategory);
    }

    function toggleUserMenu() {
        const dropdown = document.getElementById("userDropdown");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    function toggleCartMenu() {
        const dropdown = document.getElementById("cartDropdown");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    // Close dropdowns if clicking outside
    window.onclick = function(event) {
        if (!event.target.closest('.user-menu')) {
            document.getElementById("userDropdown").style.display = "none";
        }
        if (!event.target.closest('.cart-menu')) {
            document.getElementById("cartDropdown").style.display = "none";
        }
    }

    window.onload = () => loadProducts();
</script>



</body>
</html>
