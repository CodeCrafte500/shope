// Global Variables
let products = []; // Initialize as empty array
let cart = [];
let favorites = new Set();
let filteredProducts = []; // Initialize as empty array
let currentProduct = null;
let editingProductId = null;
let isAuthenticated = false;
let currentSlideIndex = 0;

//DOM Elements
const cartOverlay = document.getElementById('cartOverlay');
const cartDrawer = document.getElementById('cartDrawer');
const cartCount = document.getElementById('cartCount');
const cartItemCount = document.getElementById('cartItemCount');
const cartContent = document.getElementById('cartContent');
const cartFooter = document.getElementById('cartFooter');
const cartTotal = document.getElementById('cartTotal');
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const sortFilter = document.getElementById('sortFilter');



// Utility Functions
function formatPrice(price) {
    return new Intl.NumberFormat('ku-IQ').format(price) + " د.ع";
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'}"></i>
        ${message}
    `;
    
    const container = document.getElementById('toastContainer');
    container.appendChild(toast);
    
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (container.contains(toast)) {
                container.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

function generateUserId() {
    return Math.floor(1000000 + Math.random() * 9000000).toString();
}

// Product Functions
function renderStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += `<i class="fas fa-star star ${i <= rating ? '' : 'empty'}"></i>`;
    }
    return stars;
}

function renderProduct(product) {
    return `
        <div class="product-card" onclick="showProductDetails(${product.id})">
            <div class="product-image-container">
                <img src="${product.image}" alt="${product.name}" class="product-image">
                
                <div class="product-badges">
                    ${product.isNew ? '<span class="badge badge-new">نوێ</span>' : ''}
                    ${product.isSale ? '<span class="badge badge-sale">فرۆشتن</span>' : ''}
                </div>
                
                <button class="favorite-btn ${favorites.has(product.id) ? 'active' : ''}" 
                        onclick="event.stopPropagation(); toggleFavorite(${product.id})">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            
            <div class="product-info">
                <h3 class="product-title">${product.name}</h3>
                <p class="product-title-en">${product.nameEn}</p>
                <p class="product-description">${product.description}</p>
                
                <div class="product-rating">
                    <div class="stars">${renderStars(product.rating)}</div>
                    <span class="rating-text">${product.rating} (${product.reviews})</span>
                </div>
                
                <div class="product-price">
                    <div>
                        <span class="price-current">${formatPrice(product.price)}</span>
                        ${product.originalPrice ? `<span class="price-original">${formatPrice(product.originalPrice)}</span>` : ''}
                    </div>
                    <span class="product-brand">${product.brand}</span>
                </div>
                
                <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(${product.id})">
                    <i class="fas fa-shopping-cart"></i>
                    زیادکردن بۆ سەبەت
                </button>
            </div>
        </div>
    `;
}


 //Cart Functions
function addToCart(productId) {
    // Convert productId to number to ensure proper comparison
    const numericProductId = parseInt(productId);
    const product = products.find(p => parseInt(p.id) === numericProductId);
    console.log('Looking for product ID:', numericProductId);
    console.log('Available products:', products);
    console.log('Found product:', product);
    
    if (product) {
        const existingItem = cart.find(item => parseInt(item.id) === numericProductId);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({...product, quantity: 1});
        }
        updateCartUI();
        showToast(`${product.name} زیادکرا بۆ سەبەت`);
    } else {
        console.error('Product not found with ID:', numericProductId);
        showToast('هەڵەیەک لە زیادکردنی بەرهەم', 'error');
    }
}

function removeFromCart(index) {
    const removedProduct = cart[index];
    cart.splice(index, 1);
    updateCartUI();
    showToast(`${removedProduct.name} لابرا لە سەبەت`, 'error');
}

function updateQuantity(index, change) {
    if (cart[index]) {
        cart[index].quantity += change;
        if (cart[index].quantity < 1) {
            cart[index].quantity = 1;
        }
        updateCartUI();
    }
}

function updateCartUI() {
    cartCount.textContent = cart.length;
    cartItemCount.textContent = cart.length;
    
    if (cart.length === 0) {
        cartContent.innerHTML = `
            <div class="cart-empty">
                <i class="fas fa-shopping-bag"></i>
                <h3>سەبەتەکەت بەتاڵە</h3>
                <p>بەرهەمێک زیاد بکە بۆ سەبەتەکەت</p>
            </div>
        `;
        cartFooter.style.display = 'none';
    } else {
        cartContent.innerHTML = cart.map((item, index) => `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">${formatPrice(item.price)}</div>
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="updateQuantity(${index}, -1)" ${item.quantity <= 1 ? 'disabled' : ''}>
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="quantity-display">${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <button class="remove-btn" onclick="removeFromCart(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `).join('');
        
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        cartTotal.textContent = formatPrice(total);
        cartFooter.style.display = 'block';
    }
}

function toggleCart(id) {
    cartOverlay.classList.toggle('active');
    cartDrawer.classList.toggle('active');
}

// Modal Functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Admin Functions
function toggleAdminModal() {
    if (isAuthenticated) {
        showAdminPanel();
    } else {
        showModal('adminLoginModal');
    }
}

function showAdminPanel() {
    renderAdminProducts();
    showModal('adminPanelModal');
}

function closeAdminPanel() {
    hideModal('adminPanelModal');
}

function renderAdminProducts() {
    const adminProductsList = document.getElementById('adminProductsList');
    adminProductsList.innerHTML = products.map(product => `
        <div class="admin-product-item">
            <img src="${product.image}" alt="${product.name}" class="admin-product-image">
            <div class="admin-product-info">
                <div class="admin-product-name">${product.name}</div>
                <div class="admin-product-name-en">${product.nameEn}</div>
                <div class="admin-product-price">${formatPrice(product.price)}</div>
            </div>
            <div class="admin-product-actions">
                <button class="admin-btn-small admin-btn-edit" onclick="editProduct(${product.id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="admin-btn-small admin-btn-delete" onclick="deleteProduct(${product.id})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `).join('');
}

function showAddProductForm() {
    editingProductId = null;
    document.getElementById('productFormTitle').textContent = 'زیادکردنی بەرهەمی نوێ';
    document.getElementById('productFormSubmit').textContent = 'زیادکردن';
    clearProductForm();
    showModal('productFormModal');
}

function editProduct(productId) {
    const product = products.find(p => p.id === productId);
    if (product) {
        editingProductId = productId;
        document.getElementById('productFormTitle').textContent = 'دەستکاریکردنی بەرهەم';
        document.getElementById('productFormSubmit').textContent = 'نوێکردنەوە';
        
        // Fill form with product data
        document.getElementById('productName').value = product.name;
        document.getElementById('productNameEn').value = product.nameEn;
        document.getElementById('productDescription').value = product.description;
        document.getElementById('productPrice').value = product.price;
        document.getElementById('productOriginalPrice').value = product.originalPrice || '';
        document.getElementById('productImage').value = product.image;
        document.getElementById('productCategory').value = product.category;
        document.getElementById('productBrand').value = product.brand;
        document.getElementById('productIsSale').checked = product.isSale;
        document.getElementById('productIsNew').checked = product.isNew;
        
        showModal('productFormModal');
    }
}

function deleteProduct(productId) {
    if (confirm('ئایا دڵنیایت لە سڕینەوەی ئەم بەرهەمە؟')) {
        const index = products.findIndex(p => p.id === productId);
        if (index !== -1) {
            const deletedProduct = products[index];
            products.splice(index, 1);
            filterProducts();
            renderAdminProducts();
            showToast(`${deletedProduct.name} سڕایەوە`, 'error');
        }
    }
}

function clearProductForm() {
    document.getElementById('productForm').reset();
}

function closeProductForm() {
    hideModal('productFormModal');
    clearProductForm();
    editingProductId = null;
}

function toggleProductDetailModal() {
    hideModal('productDetailModal');
}

function addToCartFromDetail() {
    if (currentProduct) {
        addToCart(currentProduct.id);
    }
}

function toggleFavoriteFromDetail() {
    if (currentProduct) {
        toggleFavorite(currentProduct.id);
        // Update favorite button state
        const favoriteBtn = document.querySelector('.product-detail-actions .favorite-btn');
        favoriteBtn.classList.toggle('active', favorites.has(currentProduct.id));
    }
}

// Checkout Functions
function checkout() {
    if (cart.length === 0) {
        showToast('سەبەتەکەت بەتاڵە', 'error');
        return;
    }
    
    // Generate new user ID
    document.getElementById('generatedId').value = generateUserId();
    
    // Update order summary
    updateOrderSummary();
    
    toggleCart();
    showModal('checkoutModal');
}

function toggleCheckoutModal() {
    hideModal('checkoutModal');
}

function updateOrderSummary() {
    const orderItems = document.getElementById('orderItems');
    const orderTotalAmount = document.getElementById('orderTotalAmount');
    
    orderItems.innerHTML = cart.map(item => `
        <div class="order-item">
            <span>${item.name} × ${item.quantity}</span>
            <span>${formatPrice(item.price * item.quantity)}</span>
        </div>
    `).join('');
    
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    orderTotalAmount.textContent = formatPrice(total);
}

function copyGeneratedId() {
    const generatedIdInput = document.getElementById('generatedId');
    generatedIdInput.select();
    document.execCommand('copy');
    showToast('ناسنامەی ئێوە کۆپی کرا');
}

// Filter and Search Functions
function toggleFavorite(productId) {
    if (favorites.has(productId)) {
        favorites.delete(productId);
    } else {
        favorites.add(productId);
    }
    renderProducts();
}

function filterProducts() {
    const searchTerm = searchInput.value.toLowerCase();
    const category = categoryFilter.value;
    const sortBy = sortFilter.value;
    
    // Filter by search and category
    filteredProducts = products.filter(product => {
        const matchesSearch = product.name.toLowerCase().includes(searchTerm) ||
                              product.nameEn.toLowerCase().includes(searchTerm);
        const matchesCategory = category === 'all' || product.category === category;
        return matchesSearch && matchesCategory;
    });
    
    // Sort products
    filteredProducts.sort((a, b) => {
        switch (sortBy) {
            case 'price-low':
                return a.price - b.price;
            case 'price-high':
                return b.price - a.price;
            case 'rating':
                return b.rating - a.rating;
            case 'popularity':
                return b.reviews - a.reviews;
            default:
                return a.name.localeCompare(b.name);
        }
    });
    
    renderProducts();
}

// Event Listeners
document.addEventListener('DOMContentLoaded', async () => {
    // Fetch products from server
    try {
        const response = await fetch('index.php?action=get_products');
        let rawProducts = await response.json();
        
        console.log('Raw products from server:', rawProducts);
        
        products = rawProducts.map(p => ({
            id: parseInt(p.id),
            name: p.productName,
            nameEn: p.productNameEn,
            description: p.productDescription,
            price: parseFloat(p.productPrice),
            originalPrice: p.productOriginalPrice ? parseFloat(p.productOriginalPrice) : null,
            image: p.productImage,
            category: p.productCategory || '',
            brand: p.productBrand,
        }));
        
        console.log('Processed products:', products);
        filteredProducts = [...products];
    } catch (e) {
        console.error('Error fetching products:', e);
        showToast('هەڵەیەک لە هێنانەوەی بەرهەمەکان', 'error');
        products = [];
        filteredProducts = [];
    }
    updateCartUI();
    

    

 // Checkout form submission
const checkoutForm = document.getElementById('checkoutForm');
if (checkoutForm) {
    checkoutForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = {
            thirdName: document.getElementById('thirdName')?.value || '',
            phoneNumber: document.getElementById('phoneNumber')?.value || '',
            location: document.getElementById('location')?.value || '',
            generatedId: document.getElementById('generatedId')?.value || '',
            items: cart.map(item => ({
                name: item.name,
                price: item.price,
                quantity: item.quantity,
                totalPrice: item.price * item.quantity
            })),
            totalAmount: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0)
        };

        try {
            const response = await fetch('https://formspree.io/f/xkgjnzay', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                cart = [];
                updateCartUI();
                hideModal('checkoutModal');
                checkoutForm.reset();
                showToast('سوپاس! داواکاریەکەت بە سەرکەوتووی نێردرا');
            } else {
                showToast('هەڵە ڕوویدا، تکایە دووبارە تاقیبکەوە', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('هەڵەیەک ڕوویدا، تکایە دووبارە تاقیبکەوە', 'error');
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    updateCartUI();
    updateCartCount();
});
    
    // Close modals when clicking outside
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal')) {
            e.target.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });
    
    // Prevent modal content clicks from closing modal
    document.querySelectorAll('.modal-content').forEach(content => {
        content.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });
});

// Hero Slider
const slides = document.querySelectorAll('.slide');
const sliderDots = document.getElementById('sliderDots');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    initializeSlider();
    renderProducts();
    attachEventListeners();
    updateCartUI();
});

// Hero Slider Functions
function initializeSlider() {
    // Create dots
    slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        sliderDots.appendChild(dot);
    });

    // Auto-play slider
    setInterval(nextSlide, 4000);
}

function goToSlide(index) {
    slides[currentSlideIndex].classList.remove('active');
    document.querySelectorAll('.dot')[currentSlideIndex].classList.remove('active');
    
    currentSlideIndex = index;
    
    slides[currentSlideIndex].classList.add('active');
    document.querySelectorAll('.dot')[currentSlideIndex].classList.add('active');
}

function nextSlide() {
    const nextIndex = (currentSlideIndex + 1) % slides.length;
    goToSlide(nextIndex);
}

function prevSlide() {
    const prevIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
    goToSlide(prevIndex);
}
