// Menu items data
const menuItems = [
    {
        id: 1,
        name: "Bruschetta Trio",
        price: 12,
        category: "Appetizer",
        tags: ["Vegetarian", "Popular"],
        image: "Brussata.webp",
        description: "Three varieties of artisan bruschetta topped with fresh tomatoes, basil, and premium mozzarella"
    },
    {
        id: 2,
        name: "Grilled Salmon",
        price: 28,
        category: "Main Course",
        tags: ["Gluten-Free", "Chef's Special"],
        image: "salmon.jpg",
        description: "Fresh Atlantic salmon with lemon butter sauce, served with roasted vegetables and herb rice"
    },
    {
        id: 3,
        name: "Tiramisu Classic",
        price: 10,
        category: "Dessert",
        tags: ["Vegetarian", "Signature"],
        image: "Tiramisu.jpg",
        description: "Traditional Italian dessert with espresso-soaked ladyfingers and mascarpone cream"
    },
    {
        id: 4,
        name: "Cha Kdao",
        price: 12,
        category: "Appetizer",
        tags: ["Meat", "Popular"],
        image: "chakdao.jpg",
        description: "Cha Kdao is a popular Cambodian stir-fry dish featuring holy basil, chili, garlic, and meat—typically chicken"
    },
    {
        id: 5,
        name: "Cha Kh'nhei",
        price: 9,
        category: "Appetizer",
        tags: ["Meat", "Strong taste"],
        image: "cha-khnhei.webp",
        description: "cha Kh'nhei, is a traditional Cambodian stir-fry dish centered around young ginger, meat"
    }
];

// Shopping cart data
let cart = JSON.parse(localStorage.getItem('restaurantCart')) || [];

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
    // Set up filter buttons
    setupFilterButtons();
    // Set up cart
    setupCart();
    // Add click handlers to all "Add to Cart" buttons
    setupAddToCartButtons();
    // Initialize cart display
    updateCartDisplay();
});

// Filter functionality
function setupFilterButtons() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');
            
            // Get category to filter by
            const category = button.textContent.trim();
            filterMenuItems(category);
        });
    });
}

function filterMenuItems(category) {
    const menuContainer = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
    const menuArticles = menuContainer.querySelectorAll('article');

    menuArticles.forEach(article => {
        const articleCategory = article.querySelector('.absolute.top-4.right-4').textContent.trim();
        
        if (category === 'All' || 
            (category === 'Appetizers' && articleCategory === 'Appetizer') || 
            (category === 'Desserts' && articleCategory === 'Dessert') ||
            category === articleCategory) {
            article.style.display = 'block';
            article.style.opacity = '0';
            // Add animation
            setTimeout(() => {
                article.style.animation = 'fadeInUp 0.6s ease-out forwards';
                article.style.opacity = '1';
            }, 100);
        } else {
            article.style.display = 'none';
        }
    });
}

// Shopping Cart functionality
function setupCart() {
    // Add cart HTML to the page
    const cartHTML = `
        <div id="shopping-cart"  class="fixed top-20 right-0 w-80 h-screen bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-50">
            <div class="p-4 bg-gradient-warm text-white">
                <h3 class="text-xl font-bold">Your Cart</h3>
                <button id="close-cart" class="absolute top-4 right-4 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="cart-items" class="p-4 space-y-4 max-h-[calc(100vh-200px)] overflow-y-auto"></div>
            <div class="absolute bottom-0 left-0 right-0 p-4 bg-white border-t">
                <div class="flex justify-between mb-4">
                    <span class="font-bold">Total:</span>
                    <span id="cart-total" class="font-bold">$0.00</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="clearCart()" class="flex-1 py-2 bg-gray-500 text-white rounded-full hover:bg-gray-600 transition-colors">
                        Clear Cart
                    </button>
                    <button id="checkout-btn" onclick="checkout()" class="flex-1 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
        <button id="cart-toggle" class="fixed top-24 right-4 p-3 bg-orange-500 text-white rounded-full shadow-lg hover:bg-orange-600 transition-colors z-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">0</span>
        </button>
    `;
    
    document.body.insertAdjacentHTML('beforeend', cartHTML);
    
    // Setup cart toggle
    const cartToggle = document.getElementById('cart-toggle');
    const closeCart = document.getElementById('close-cart');
    const cart = document.getElementById('shopping-cart');
    
    cartToggle.addEventListener('click', () => {
        cart.classList.toggle('translate-x-full');
    });
    
    closeCart.addEventListener('click', () => {
        cart.classList.add('translate-x-full');
    });
}

function setupAddToCartButtons() {
    const addButtons = document.querySelectorAll('article button');
    
    addButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const article = button.closest('article');
            const itemName = article.querySelector('h3').textContent;
            const itemPrice = parseFloat(article.querySelector('.text-orange-500').textContent.replace('$', ''));
            
            addToCart({
                id: menuItems[index].id,
                name: itemName,
                price: itemPrice,
                quantity: 1
            });
        });
    });
}

function addToCart(item) {
    const existingItem = cart.find(cartItem => cartItem.id === item.id);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push(item);
    }
    
    // Save to localStorage
    localStorage.setItem('restaurantCart', JSON.stringify(cart));
    
    updateCartDisplay();
    // Show animation
    document.getElementById('cart-toggle').classList.add('animate-bounce');
    setTimeout(() => {
        document.getElementById('cart-toggle').classList.remove('animate-bounce');
    }, 1000);
}

function updateCartDisplay() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    const cartCount = document.getElementById('cart-count');
    
    // Clear current display
    cartItems.innerHTML = '';
    
    // Add each item to the cart display
    cart.forEach(item => {
        const itemHTML = `
            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                <div>
                    <h4 class="font-semibold">${item.name}</h4>
                    <p class="text-gray-600">$${item.price} × ${item.quantity}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="p-1 text-gray-600 hover:text-orange-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                    </button>
                    <span>${item.quantity}</span>
                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="p-1 text-gray-600 hover:text-orange-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        cartItems.insertAdjacentHTML('beforeend', itemHTML);
    });
    
    // Update total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    cartTotal.textContent = `$${total.toFixed(2)}`;
    
    // Update count
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = count;
}

// Update quantity function
function updateQuantity(itemId, newQuantity) {
    if (newQuantity <= 0) {
        // Remove item from cart
        cart = cart.filter(item => item.id !== itemId);
    } else {
        // Update quantity
        const item = cart.find(cartItem => cartItem.id === itemId);
        if (item) {
            item.quantity = newQuantity;
        }
    }
    
    // Save to localStorage
    localStorage.setItem('restaurantCart', JSON.stringify(cart));
    updateCartDisplay();
}

// Clear cart function
function clearCart() {
    cart = [];
    localStorage.removeItem('restaurantCart');
    updateCartDisplay();
}

// Checkout function
function checkout() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const itemCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    let orderSummary = `Order Summary:\n\n`;
    cart.forEach(item => {
        orderSummary += `${item.name} × ${item.quantity} = $${(item.price * item.quantity).toFixed(2)}\n`;
    });
    orderSummary += `\nTotal: $${total.toFixed(2)}\nItems: ${itemCount}`;
    
    if (confirm(`${orderSummary}\n\nProceed to checkout?`)) {
        alert('Order placed successfully! Your food will be ready soon.');
        clearCart();
    }
}
