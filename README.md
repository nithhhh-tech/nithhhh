<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Savory Bites Restaurant - Delicious cuisine with fresh ingredients" />
  <title>Savory Bites | Restaurant Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* EXPLANATION: Custom animations using @keyframes */
    /* fadeInUp makes elements appear from bottom with fade effect */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    /* EXPLANATION: Staggered animation delays */
    /* Each menu item appears one after another with different delays */
    .menu-item {
      animation: fadeInUp 0.6s ease-out forwards;
      /* keep visible even if animation doesn't trigger */
      opacity: 1;
    }
    
    .menu-item:nth-child(1) { animation-delay: 0.1s; }
    .menu-item:nth-child(2) { animation-delay: 0.2s; }
    .menu-item:nth-child(3) { animation-delay: 0.3s; }
    .menu-item:nth-child(4) { animation-delay: 0.4s; }
    .menu-item:nth-child(5) { animation-delay: 0.5s; }
    .menu-item:nth-child(6) { animation-delay: 0.6s; }
    
    .bg-gradient-warm {
      background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    }
    
    .filter-btn.active {
      background: #ff6b35;
      color: white;
      transform: scale(1.05);
    }
    

    .image-overlay {
      background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
    }
  </style>
</head>
<body class="bg-amber-50 text-gray-800">
  <nav class="fixed top-0 w-full z-50 backdrop-blur-md bg-white/90 shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <!-- Logo with gradient text -->
        <a href="#" class="text-3xl font-bold bg-gradient-warm bg-clip-text text-transparent">
        🍴Strawhats Bites
        </a>
        <!-- Navigation links -->
        <div class="hidden md:flex space-x-8">
          <a href="#home" class="text-gray-700 hover:text-orange-500  transition-colors duration-300 font-medium">Home</a>
          <a href="#menu" class="text-gray-700 hover:text-orange-500 transition-colors duration-300 font-medium">Menu</a>
          <a href="#about" class="text-gray-700 hover:text-orange-500 transition-colors duration-300 font-medium">About</a>
          <a href="#contact" class="text-gray-700 hover:text-orange-500 transition-colors duration-300 font-medium">Contact</a>
        </div>
        
        <!-- Call to action button -->
        <button class="hidden md:block px-6 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-all duration-300 hover:scale-105 shadow-lg"><a href="https://www.tiktok.com/@rickastleyofficial/video/7512867562258992406?is_from_webapp=1&sender_device=pc">Reserve Table</a>
        </button>        
        <!-- Mobile menu button -->
        <button class="md:hidden text-orange-500">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>
  </nav>
  <section id="home" class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20 bg-gradient-warm">
    <div class="absolute inset-0 opacity-20">
      <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full filter blur-3xl"></div>
      <div class="absolute bottom-20 right-10 w-96 h-96 bg-yellow-200 rounded-full filter blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10 text-white">
      <h1 class="text-6xl md:text-8xl font-black mb-6 drop-shadow-2xl">
        Welcome to<br/>Strawhats Bites
      </h1>
      <p class="text-2xl md:text-3xl mb-8 font-light">
        Where Every Bite Tells a Delicious Story
      </p>
      <p class="text-lg mb-12 max-w-2xl mx-auto opacity-90">
        Experience culinary excellence with our chef-crafted dishes made from the finest locally-sourced ingredients
      </p>
      <a href="#menu" class="inline-block px-8 py-4 bg-white text-orange-500 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 hover:scale-105 shadow-2xl">
        VIEW OUR MENU
      </a>
    </div>
  </section>

  <!-- EXPLANATION: Menu Section -->
  <section id="menu" class="py-24">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <h2 class="text-5xl md:text-6xl font-bold mb-4 text-gray-800">
          Our <span class="text-orange-500">Menu</span>
        </h2>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
          Crafted with passion, served with love. Every dish is a masterpiece.
        </p>
      </div>

      <!-- EXPLANATION: Filter buttons for categories -->
      <!-- These would work with JavaScript to filter menu items by category -->
      <div class="flex flex-wrap justify-center gap-4 mb-12">
        <button class="filter-btn active px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white transition-all duration-300">
          All
        </button>
        <button class="filter-btn px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white transition-all duration-300">
          Appetizers
        </button>
        <button class="filter-btn px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white transition-all duration-300">
          Main Course
        </button>
        <button class="filter-btn px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white transition-all duration-300">
          Desserts
        </button>
        <button class="filter-btn px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white transition-all duration-300">
          Beverages
        </button>
      </div>

      <!-- EXPLANATION: Grid layout for menu items -->
      <!-- grid-cols-1 (mobile), md:grid-cols-2 (tablet), lg:grid-cols-3 (desktop) -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <!-- EXPLANATION: Menu Card Structure -->
        <!-- Each card has: image, content, price, and order button -->
        
        <!-- Menu Item 1 -->
        <article class="menu-item group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
          <!-- Image container with overlay effect -->
          <div class="relative h-64 overflow-hidden">
            <div class="w-full h-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center "><img src="images/Brussata.webp" alt="Bruschetta">
              <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
              </svg>
            </div>
            <!-- Overlay appears on hover -->
            <div class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <!-- Category badge -->
            <span class="absolute top-4 right-4 px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full">
              Appetizer
            </span>
          </div>
          
          <!-- Card content -->
          <div class="p-6" >
            <div class="flex justify-between items-start mb-3" >
              <h3 class="text-2xl font-bold text-gray-800">Bruschetta Trio</h3>
              <span class= "text-2xl font-bold text-orange-500">$12 </span>
            </div>
            <p class="text-gray-600 mb-4">
              Three varieties of artisan bruschetta topped with fresh tomatoes, basil, and premium mozzarella
            </p>
            <!-- EXPLANATION: Flex layout for tags and button -->
            <div class="flex items-center justify-between">
              <div class="flex gap-2">
                <span class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded-full">Vegetarian</span>
                <span class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded-full">Popular</span>
              </div>
              <button class="p-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
              </button>
            </div>
          </div>
        </article>

        <!-- Menu Item 2 -->
        <article class="menu-item group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
          <div class="relative h-64 overflow-hidden">
            <div class="w-full h-full bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center"><img src="images/salmon.jpg" alt="Salmon">
              <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
            <div class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <span class="absolute top-4 right-4 px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">
              Main Course
            </span>
          </div>
          <div class="p-6">
            <div class="flex justify-between items-start mb-3">
              <h3 class="text-2xl font-bold text-gray-800">Grilled Salmon</h3>
              <span class="text-2xl font-bold text-orange-500">$28</span>
            </div>
            <p class="text-gray-600 mb-4">
              Fresh Atlantic salmon with lemon butter sauce, served with roasted vegetables and herb rice
            </p>
            <div class="flex items-center justify-between">
              <div class="flex gap-2">
                <span class="text-xs px-3 py-1 bg-purple-100 text-purple-700 rounded-full">Gluten-Free</span>
                <span class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded-full">Chef's Special</span>
              </div>
              <button class="p-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
              </button>
            </div>
          </div>
        </article>

        <!-- Menu Item 3 -->
        <article class="menu-item group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
          <div class="relative h-64 overflow-hidden">
            <div class="w-full h-full bg-gradient-to-br flex items-center justify-center"><img src="images/Tiramisu.jpg" alt="">
              <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
              </svg>
            </div>
            <div class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <span class="absolute top-4 right-4 px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">
              Dessert
            </span>
          </div>
          <div class="p-6">
            <div class="flex justify-between items-start mb-3">
              <h3 class="text-2xl font-bold text-gray-800">Tiramisu Classic</h3>
              <span class="text-2xl font-bold text-orange-500">$10</span>
            </div>
            <p class="text-gray-600 mb-4">
              Traditional Italian dessert with espresso-soaked ladyfingers and mascarpone cream
            </p>
            <div class="flex items-center justify-between">
              <div class="flex gap-2">
                <span class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded-full">Vegetarian</span>
                <span class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded-full">Signature</span>
              </div>
              <button class="p-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
              </button>
            </div>
          </div>
        </article>

        <article class="menu-item group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
          <div class="relative h-64 overflow-hidden">
            <div class="w-full h-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center "><img src="chakdao.jpg">
              <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
              </svg>
            </div>
            <div class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <span class="absolute top-4 right-4 px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full">
              Appetizer
            </span>
          </div>
          
          <!-- Card content -->
          <div class="p-6" >
            <div class="flex justify-between items-start mb-3" >
              <h3 class="text-2xl font-bold text-gray-800" >Cha Kdao</h3>
              <span class= "text-2xl font-bold text-orange-500">$12 </span>
            </div>
            <p class="text-gray-600 mb-4">
Cha Kdao is a popular Cambodian stir-fry dish featuring holy basil, chili, garlic, and meat—typically chicken             </p>
            
            <!-- EXPLANATION: Flex layout for tags and button -->
            <div class="flex items-center justify-between">
              <div class="flex gap-2">
                <span class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded-full">Meat</span>
                <span class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded-full">Popular</span>
              </div>
              <button class="p-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
              </button>
            </div>
          </div>
        </article>
        <!-- Menu Item 5 -->
        <article class="menu-item group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
          <div class="relative h-64 overflow-hidden">
            <div class="w-full h-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center"><img src="cha-khnhei.webp">
              <svg class="w-24 h-24 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <span class="absolute top-4 right-4 px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full">
              Appetizer
            </span>
          </div>
          <div class="p-6">
            <div class="flex justify-between items-start mb-3">
              <h3 class="text-2xl font-bold text-gray-800">Cha Kh'nhei</h3>
              <span class="text-2xl font-bold text-orange-500">$9</span>
            </div>
            <p class="text-gray-600 mb-4">
              cha Kh'nhei, is a traditional Cambodian stir-fry dish centered around young ginger, meat
            </p>
            <div class="flex items-center justify-between">
              <div class="flex gap-2">
                <span class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded-full">Meat</span>
                <span class="text-xs px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full">Strong taste</span>
              </div>
              <button class="p-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
      </div>
    </div>
  </section>

  <!-- EXPLANATION: About Section with two-column layout -->
  <section id="about" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h2 class="text-5xl font-bold mb-6">
            About <span class="text-orange-500">Us</span>
          </h2>
          <p class="text-gray-600 text-lg mb-6 leading-relaxed">
            Founded in 2020, Strawhats Bites has become a beloved destination for food enthusiasts seeking exceptional dining experiences. Our passionate chefs combine traditional techniques with modern innovation to create unforgettable flavors.
          </p>
          <p class="text-gray-600 text-lg mb-6 leading-relaxed">
            We source ingredients from local farms and artisans, ensuring every dish is fresh, sustainable, and bursting with flavor. Our commitment to quality and hospitality makes every visit special.
          </p>
          <div class="grid grid-cols-3 gap-6 mt-8">
            <div class="text-center">
              <div class="text-4xl font-bold text-orange-500 mb-2">500+</div>
              <div class="text-gray-600">Happy Customers</div>
            </div>
            <div class="text-center">
              <div class="text-4xl font-bold text-orange-500 mb-2">20+</div>
              <div class="text-gray-600">Menu Items</div>
            </div>
            <div class="text-center">
              <div class="text-4xl font-bold text-orange-500 mb-2">9.9</div>
              <div class="text-gray-600">Rating</div>
            </div>
          </div>
        </div>
        
        <div class="relative">
          <div class="w-full h-full h-96 bg-gradient-to-br from-orange-400 to-red-500 rounded-3xl shadow-2xl flex items-center justify-center"><img src="wp7554548.webp" alt="">
            <svg class="w-40 h-40 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- EXPLANATION: Contact Section with form -->
  <section id="contact" class="py-24 bg-gradient-warm">
    <div class="max-w-4xl mx-auto px-6 text-center">
      <h2 class="text-5xl font-bold mb-6 text-white">
        Get In <span class="text-yellow-200">Touch</span>
      </h2>
      <p class="text-white/90 text-lg mb-12">
        Have questions or want to make a reservation? We'd love to hear from you!
      </p>
      
      <!-- EXPLANATION: Contact form with proper spacing and styling -->
      <form class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
        <div class="grid md:grid-cols-2 gap-6 mb-6">
          <input 
            type="text" 
            name="name"
            placeholder="Your Name" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" />
          <input 
            type="email"
            name="email"
            placeholder="Your Email"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" />
        </div>
        <div class="mb-6">
          <input
            type="text"
            name="subject"
            placeholder="Subject"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" />
        </div>
        <div class="mb-6">
          <textarea
            name="message"
            rows="6"
            placeholder="Your message"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
        </div>
        <div class="flex justify-center">
          <button type="submit" class="px-8 py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors">Send Message</button>
        </div>
      </form>
    </div>
  </section>

  <!-- EXPLANATION: About Section with two-column layout -->
  <section id="about" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6">
      <!-- content elided - keep original about content if needed -->
    </div>
  </section>

  <footer class="text-center text-gray-500 py-6">© 2025 Strawhats Bites</footer>

</body>
</html>
