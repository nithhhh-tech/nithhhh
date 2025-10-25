<?php
session_start();
include 'config.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if($row = mysqli_fetch_assoc($result)){
        if(password_verify($password, $row['password'])){
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: index.php"); // redirect to homepage after login
            exit();
        } else {
            $error = "❌ Wrong password!";
        }
    } else {
        $error = "❌ User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Big Bites Restaurant - Login" />
  <title>Big Bites | Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-container {
      animation: fadeIn 0.6s ease-out;
    }

    .bg-gradient-warm {
      background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    }

    .input-focus {
      transition: all 0.3s ease;
    }

    .input-focus:focus {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 107, 53, 0.2);
    }

    /* Background pattern */
    .pattern-bg {
      background-color: #fff5f0;
      background-image: 
        radial-gradient(circle at 25px 25px, rgba(255, 107, 53, 0.05) 2%, transparent 0%),
        radial-gradient(circle at 75px 75px, rgba(247, 147, 30, 0.05) 2%, transparent 0%);
      background-size: 100px 100px;
    }

    .glass-effect {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }
  </style>
</head>
<body class="pattern-bg min-h-screen flex items-center justify-center p-4">
  
  <!-- Login Container -->
  <div class="login-container w-full max-w-md">
    
    <!-- Logo and Header -->
    <div class="text-center mb-8">
      <div class="inline-block bg-white rounded-full p-4 shadow-lg mb-4 transform hover:scale-105 transition-transform duration-300">
        <img src="logo big.png" alt="Big Bites Logo" class="w-20 h-20">
      </div>
      <h1 class="text-4xl font-black mb-2">
        <span class="bg-gradient-warm bg-clip-text text-transparent">Big Bites</span>
      </h1>
      <p class="text-gray-600">Welcome back! Please login to continue</p>
    </div>

    <!-- Login Form Card -->
    <div class="glass-effect rounded-3xl shadow-2xl p-8">
      <form id="loginForm" class="space-y-6">
        
        <!-- Success Message (hidden by default) -->
        <div id="successMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl text-center">
          <p class="font-semibold">✓ Login Successful!</p>
          <p class="text-sm">Redirecting...</p>
        </div>

        <!-- Error Message (hidden by default) -->
        <div id="errorMessage" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-center">
          <p class="font-semibold">✕ Login Failed</p>
          <p class="text-sm">Invalid username or password</p>
        </div>

        <!-- Username Field -->
        <div>
          <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
            Username
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <input 
              type="text" 
              id="username" 
              name="username" 
              required
              class="input-focus w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-400"
              placeholder="Enter your username"
            />
          </div>
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
            Password
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <input 
              type="password" 
              id="password" 
              name="password" 
              required
              class="input-focus w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-400"
              placeholder="Enter your password"
            />
            <button 
              type="button" 
              id="togglePassword"
              class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600"
            >
              <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
          <label class="flex items-center">
            <input type="checkbox" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-400">
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
          </label>
          <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-semibold">
            Forgot password?
          </a>
        </div>

        <!-- Login Button -->
        <button 
          type="submit"
          class="w-full py-3 bg-gradient-warm text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2"
        >
          <span>Login</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </button>

        <!-- Divider -->
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white text-gray-500">Or continue with</span>
          </div>
        </div>

        <!-- Social Login Buttons -->
        <div class="grid grid-cols-2 gap-4">
          <button 
            type="button"
            class="flex items-center justify-center gap-2 py-3 px-4 border-2 border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-300"
          >
            <svg class="w-5 h-5" viewBox="0 0 24 24">
              <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
              <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
              <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
              <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span class="text-sm font-semibold text-gray-700">Google</span>
          </button>
          
          <button 
            type="button"
            class="flex items-center justify-center gap-2 py-3 px-4 border-2 border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-300"
          >
            <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            <span class="text-sm font-semibold text-gray-700">Facebook</span>
          </button>
        </div>

      </form>

      <!-- Sign Up Link -->
      <div class="mt-6 text-center">
        <p class="text-gray-600">
          Don't have an account? 
          <a href="#" class="text-orange-500 hover:text-orange-600 font-bold">Sign up</a>
        </p>
      </div>
    </div>

    <!-- Back to Home -->
    <div class="text-center mt-6">
      <a href="index.html" class="inline-flex items-center gap-2 text-gray-600 hover:text-orange-500 transition-colors duration-300">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        <span class="font-semibold">Back to Home</span>
      </a>
    </div>

  </div>

  <script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      // Toggle eye icon
      if (type === 'password') {
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      } else {
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
      }
    });

    // Handle form submission
    const loginForm = document.getElementById('loginForm');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');

    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Hide any previous messages
      successMessage.classList.add('hidden');
      errorMessage.classList.add('hidden');

      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;

      // Demo credentials (replace with actual authentication)
      if (username === 'admin' && password === 'admin123') {
        // Show success message
        successMessage.classList.remove('hidden');
        
        // Simulate redirect after 1.5 seconds
        setTimeout(() => {
          window.location.href = 'index.html';
        }, 1500);
      } else {
        // Show error message
        errorMessage.classList.remove('hidden');
        
        // Hide error after 3 seconds
        setTimeout(() => {
          errorMessage.classList.add('hidden');
        }, 3000);
      }
    });

    // Add floating animation to logo
    const logo = document.querySelector('img[alt="Big Bites Logo"]');
    if (logo) {
      setInterval(() => {
        logo.style.transform = 'translateY(-5px)';
        setTimeout(() => {
          logo.style.transform = 'translateY(0)';
        }, 500);
      }, 2000);
    }
  </script>

</body>
</html>
