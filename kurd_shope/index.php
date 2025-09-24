<?php
include ("connection.php");
session_start();

// Log out admin if visiting home page while logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    session_unset();
    session_destroy();
    // Optionally, reload the page to clear session cookie
    header("Location: index.php");
    exit;
}

// API endpoint for products
if (isset($_GET['action']) && $_GET['action'] === 'get_products') {
    header('Content-Type: application/json');
    $result = mysqli_query($conn, "SELECT * FROM products");
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    echo json_encode($products);
    exit;

}


?>




<!DOCTYPE html>
<html lang="ku" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بازاڕی ئەلیکترۆنی کوردستان - Kurdistan Shopping</title>
    <meta name="description" content="باشترین بەرهەمە جوانکاری و چاودێریەکان بە نرخی گونجاو و کوالیتی بەرز">
    <meta name="author" content="Kurd Shop">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
     <section class="hero-slider" id="heroSlider">
                <div class="slider-container">
                    <div class="slide active">
                        <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="مجموعة منتجات فاخرة">
                        <div class="slide-content">
                            <h2> مەیکئەپ </h2>
                            <p class="slide-subtitle">Luxury Beauty Collection</p>
                            <p class="slide-description">     </p>
                            <!-- <button class="slide-btn">تسوق الآن</button> -->
                                <h1>ئێستا بازاڕی بکە</h1>

                        </div>
                    </div>
                    <div class="slide">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="عطور راقية ومميزة">
                        <div class="slide-content">
                            <h2>بۆن  </h2>
                            <p class="slide-subtitle">Premium Fragrances</p>
                            <p class="slide-description">بۆنە ئۆرجیناڵەکان لێرەن    </p>
                            <!-- <button class="slide-btn">تسوق الآن</button> -->
                             <h1>ئێستا بازاڕی بکە</h1>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="منتجات العناية بالبشرة">
                        <div class="slide-content">
                            <h2>باشترین بەرهەمەکانی پێست   </h2>
                            <p class="slide-subtitle">Skincare Essentials</p>
                            <p class="slide-description">باشترین بەرهەمەکان بۆ جووانتر کردنی ڕۆژەکەت</p>
                            <!-- <button class="slide-btn">تسوق الآن</button> -->
                                <h1>ئێستا بازاڕی بکە</h1>
                        </div>
                    </div>
                </div>
                <button class="slider-btn prev" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="slider-btn next" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <div class="slider-dots" id="sliderDots"></div>
            </section>

        <div class="container">
              <!-- Header -->
    <header class="header">

            <div class="header-content">
                <h1 class="logo">Zelda</h1>

                <div class="header-actions">
                       <div class="search-container">
                    <input type="text" class="search-input" placeholder="گەڕان بۆ بەرهەمەکان..." id="searchInput">
                    <i class="fas fa-search search-icon"></i>
                </div>
                    <button class="cart-btn" onclick="toggleCart()">
                        <i class="fas fa-shopping-cart"></i>
                        سەبەتە
                        <span class="cart-count" id="cartCount">0</span>
                    </button>
                    
                    <button class="admin-btn" onclick="window.location.href='admin_login.php'">
                        <i class="fas fa-user"></i>
                    </button>
                </div>
            </div>
            <!-- Navigation Bar -->
<nav class="navbar">
    <div class="container">
        <ul class="nav-links">
            <li><a href="index.php">Makeup</a></li>
            <li><a href="mobile.php">Mobile</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">پەیوەندی</a></li>
          
        </ul>
    </div>
</nav>

    </header>

    
<!--Cart Drawer-->
    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>
    <div class="cart-drawer" id="cartDrawer">
        <div class="cart-header">
            <h2 class="cart-title">سەبەتی بازاڕکردن (<span id="cartItemCount">0</span> شت)</h2>
            <button class="close-btn" onclick="toggleCart()">&times;</button>
        </div>
        
        <div class="cart-content" id="cartContent">
            <div class="cart-empty">
                <i class="fas fa-shopping-bag"></i>
                <h3>سەبەتەکەت بەتاڵە</h3>
                <p>بەرهەمێک زیاد بکە بۆ سەبەتەکەت</p>
            </div>
        </div>
        
        <div class="cart-footer" id="cartFooter" style="display: none;">
            <div class="cart-total">
                <span>کۆی گشتی:</span>
                <span id="cartTotal">0 د.ع</span>
            </div>
            <button class="checkout-btn" onclick="checkout()">
                <i class="fas fa-credit-card"></i>
                ناردن
            </button>
        </div>
    </div>
    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="hero-section">
            </div>
          <!-- Products Grid -->
            <div class="products-grid" id="">
                <?php
                $result = mysqli_query($conn, "SELECT * FROM products");
                if ($result && mysqli_num_rows($result) > 0):
                    while ($product = mysqli_fetch_assoc($result)):
                ?>
                <div class="product-card"    >
                    <div class="product-image-container">
                        <img src="<?= htmlspecialchars($product['productImage']) ?>" alt="<?= htmlspecialchars($product['productName']) ?>" class="product-image">
            
                
                        <!-- You can add favorite button logic here if needed -->
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?= htmlspecialchars($product['productName']) ?></h3>
                        <p class="product-title-en"><?= htmlspecialchars($product['productNameEn']) ?></p>
                        <p class="product-description"><?= htmlspecialchars($product['productDescription']) ?></p>
                        <div class="product-price">
                            <div>
                                <span class="price-current"><?= number_format($product['productPrice']) ?> د.ع</span>
                            </div>
                            <span class="product-brand"><?= htmlspecialchars($product['productBrand']) ?></span>
                        </div>
                        <!-- Add to Cart button handled by JavaScript -->
                       <button type="button" class="add-to-cart-btn" onclick="addToCart('<?= $product['id'] ?>')">

                            <i class="fas fa-shopping-cart"></i>
                            زیادکردن بۆ سەبەت
                        </button>
                    </div>

                    
                </div>
                <?php
                    endwhile;
                else: ?>
             
                <?php endif; ?>
    </main>

    <!-- check out Modal -->
    <div class="overlay" id="checkoutOverlay" onclick="toggleCheckoutModal()"></div> 
 <div id="checkoutModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>تکایە زانیاریەکانت بنووسە</h2>
            <button class="close" onclick="toggleCheckoutModal()">&times;</button>
        </div>

        <form id="checkoutForm" class="checkout-form">
            <div class="form-group">
                <label for="thirdName">ناوی سێیەم:</label>
                <input type="text" id="thirdName" name="thirdName" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">ژمارە مۆبایل:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" maxlength="11" pattern="\d{11}" oninput="this.value = this.value.replace(/\D/g, '')" required>
            </div>

            <div class="form-group">
                <label for="location">شوێن/شار:</label>
                <input type="text" id="location" name="location" required>
            </div>

            <div class="form-group">
                <label for="generatedId">ناسنامەی داشبۆرد:</label>
                <div class="input-with-copy">
                    <input type="text" id="generatedId" name="generatedId" readonly>
                    <button type="button" class="copy-btn" onclick="copyGeneratedId()">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <div class="order-summary" id="orderSummary">
                <h3>کورتەی داواکاری</h3>
                <div id="orderItems"></div>
                <div class="order-total">
                    <span>کۆی گشتی:</span>
                    <span id="orderTotalAmount">0 د.ع</span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-credit-card"></i>
                ناردن
            </button>
        </form>
    </div>
</div>
   

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>بازاڕی کوردستان</h3>
                    <p>باشترین بەرهەمە جوانکاری و چاودێریەکان بە نرخی گونجاو و کوالیتی بەرز</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/share/19RzUjhmzv/"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="tel:07707080922"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://t.me/barham_62"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>پەیوەندی</h3>
                    <p><i class="fas fa-phone"></i>07707080922</p>
                    <p><i class="fas fa-envelope"></i> barhamhusen456@gmail.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> سلێمانی، کوردستان</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>


    <script src="scripts.js">

    const searchInput = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('resultsContainer');

    searchInput.addEventListener('input', function() {
        const query = this.value;
        if (query.length > 0) {
            fetch(`search.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    if (data.length > 0) {
                        resultsContainer.style.display = 'block';
                        data.forEach(product => {
                            const div = document.createElement('div');
                            div.classList.add('result-item');
                            div.textContent = `${product.productName} (${product.productNameEn})`;
                            div.onclick = function() {
                                searchInput.value = product.productName;
                                resultsContainer.style.display = 'none';
                            };
                            resultsContainer.appendChild(div);
                        });
                    } else {
                        resultsContainer.style.display = 'none';
                    }
                });
        } else {
            resultsContainer.style.display = 'none';
        }
    });


    </script>
</body>
</html>



