<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Strawhats Bites Restaurant - Delicious cuisine with fresh ingredients" />
  <title>Big Bite | Restaurant Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="menu.js" defer></script>
  <script>
// Table Management System
let tableReservations = {};
let selectedTable = null;

// Initialize tables with some sample reservations for demo
function initializeTables() {
  if (Object.keys(tableReservations).length === 0) {
    // Add some sample reservations
    const today = new Date().toISOString().split('T')[0];
    tableReservations = {
      'table-1': { date: today, time: '18:00', name: 'John Doe', phone: '123-456-7890', guests: '2', status: 'reserved' },
      'table-3': { date: today, time: '19:00', name: 'Jane Smith', phone: '098-765-4321', guests: '4', status: 'reserved' },
      'table-7': { date: today, time: '20:00', name: 'Mike Johnson', phone: '555-123-4567', guests: '6', status: 'reserved' }
    };
  }
}

// Reservation Modal Functionsa
function openReservationModal() {
  const modal = document.getElementById('reservationModal');
  const modalContent = document.getElementById('modalContent');
  modal.classList.remove('hidden');
  setTimeout(() => {
    modalContent.classList.remove('scale-95', 'opacity-0');
    modalContent.classList.add('scale-100', 'opacity-100');
  }, 10);
  updateTableDisplay();
}

function closeReservationModal() {
  const modalContent = document.getElementById('modalContent');
  modalContent.classList.remove('scale-100', 'opacity-100');
  modalContent.classList.add('scale-95', 'opacity-0');
  setTimeout(() => {
    document.getElementById('reservationModal').classList.add('hidden');
    selectedTable = null;
    updateTableDisplay();
  }, 300);
}

// Table Selection Functions
function selectTable(tableId) {
  console.log('Selecting table:', tableId);
  const table = document.getElementById(tableId);
  const reservation = tableReservations[tableId];
  
  console.log('Table element:', table);
  console.log('Reservation for this table:', reservation);
  
  if (reservation && reservation.status === 'reserved') {
    alert(`Table ${tableId.split('-')[1]} is already reserved by ${reservation.name} at ${reservation.time}`);
    return;
  }
  
  // Remove previous selection
  document.querySelectorAll('.table-item').forEach(t => t.classList.remove('selected'));
  
  // Select new table
  table.classList.add('selected');
  selectedTable = tableId;
  
  console.log('Selected table:', selectedTable);
  
  // Update form with table info
  const selectedTableInfo = document.getElementById('selectedTableInfo');
  if (selectedTableInfo) {
    selectedTableInfo.textContent = `Table ${tableId.split('-')[1]} selected`;
    selectedTableInfo.classList.remove('hidden');
    console.log('Updated selected table info');
  } else {
    console.log('Selected table info element not found');
  }
}

function updateTableDisplay() {
  const today = new Date().toISOString().split('T')[0];
  const selectedDate = document.getElementById('reservationDate')?.value || today;
  
  console.log('Updating table display for date:', selectedDate);
  console.log('Current reservations:', tableReservations);
  
  document.querySelectorAll('.table-item').forEach(table => {
    const tableId = table.id;
    const reservation = tableReservations[tableId];
    
    // Reset classes
    table.classList.remove('reserved', 'available', 'selected');
    
    if (reservation && reservation.date === selectedDate && reservation.status === 'reserved') {
      table.classList.add('reserved');
      table.title = `Reserved by ${reservation.name} at ${reservation.time}`;
      console.log(`Table ${tableId} is reserved`);
    } else {
      table.classList.add('available');
      table.title = 'Available';
      console.log(`Table ${tableId} is available`);
    }
  });
}

function saveReservation() {
  if (!selectedTable) {
    alert('Please select a table first!');
    return false;
  }
  
  const formData = new FormData(document.getElementById('reservationForm'));
  const reservation = {
    date: formData.get('date'),
    time: formData.get('time'),
    name: formData.get('name'),
    phone: formData.get('phone'),
    guests: formData.get('guests'),
    requests: formData.get('requests'),
    status: 'reserved',
    timestamp: new Date().toISOString()
  };
  
  console.log('Saving reservation:', reservation);
  console.log('For table:', selectedTable);
  
  tableReservations[selectedTable] = reservation;
  localStorage.setItem('tableReservations', JSON.stringify(tableReservations));
  
  console.log('Reservation saved to localStorage');
  console.log('Updated tableReservations:', tableReservations);
  
  // Update table display to show the new reservation
  updateTableDisplay();
  
  return true;
}

function showReservations() {
  // Reload from localStorage to get latest data
  tableReservations = JSON.parse(localStorage.getItem('tableReservations')) || {};
  
  console.log('Current reservations from localStorage:', tableReservations);
  console.log('Raw localStorage data:', localStorage.getItem('tableReservations'));
  
  const reservations = Object.entries(tableReservations).filter(([key, value]) => value.status === 'reserved');
  
  if (reservations.length === 0) {
    alert('No reservations found!\n\nCheck console for debugging info.');
    return;
  }
  
  let reservationList = 'Current Reservations:\n\n';
  reservations.forEach(([tableId, reservation]) => {
    const tableNumber = tableId.split('-')[1];
    reservationList += `Table ${tableNumber}:\n`;
    reservationList += `  Name: ${reservation.name}\n`;
    reservationList += `  Phone: ${reservation.phone}\n`;
    reservationList += `  Date: ${reservation.date}\n`;
    reservationList += `  Time: ${reservation.time}\n`;
    reservationList += `  Guests: ${reservation.guests}\n`;
    if (reservation.requests) {
      reservationList += `  Requests: ${reservation.requests}\n`;
    }
    reservationList += '\n';
  });
  
  alert(reservationList);
}

// Test function to check localStorage
function testLocalStorage() {
  console.log('Testing localStorage...');
  localStorage.setItem('test', 'Hello World');
  const testValue = localStorage.getItem('test');
  console.log('Test value:', testValue);
  alert('localStorage test: ' + testValue);
}

window.onload = function() {
  console.log('Page loaded, initializing tables...');
  initializeTables();
  
  // Close modal when clicking outside
  document.getElementById('reservationModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeReservationModal();
    }
  });

  // Contact Form Handler (keeping original functionality)
  document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
      <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      Sending...
    `;

    // Simulate form submission (you can replace with actual email service)
    setTimeout(() => {
      document.getElementById('contact-form').reset();
      
      const successMessage = document.getElementById('success-message');
      if (!successMessage) {
        const msg = document.createElement('div');
        msg.id = 'success-message';
        msg.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 text-center';
        msg.innerHTML = '✓ Message sent successfully! We\'ll get back to you soon.';
        document.getElementById('contact-form').insertAdjacentElement('beforebegin', msg);
        setTimeout(() => msg.remove(), 5000);
      } else {
        successMessage.classList.remove('hidden');
        setTimeout(() => successMessage.classList.add('hidden'), 5000);
      }

      submitBtn.disabled = false;
      submitBtn.innerHTML = originalText;
    }, 2000);
  });

  // Reservation Form Handler
  document.getElementById('reservationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    console.log('Form submitted!');
    console.log('Selected table:', selectedTable);
    console.log('Form data:', new FormData(this));
    
    if (!saveReservation()) {
      console.log('Save reservation failed!');
      return;
    }
    
    console.log('Reservation saved successfully!');
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
      <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      Processing...
    `;

    setTimeout(() => {
      // Show detailed confirmation
      const reservationData = tableReservations[selectedTable];
      const successDiv = document.createElement('div');
      successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl mb-6';
      successDiv.innerHTML = `
        <div class="flex items-center gap-3 mb-3">
          <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold">Reservation Confirmed!</h3>
        </div>
        <div class="bg-white/50 rounded-lg p-4 space-y-2">
          <p><strong>Name:</strong> ${reservationData.name}</p>
          <p><strong>Phone:</strong> ${reservationData.phone}</p>
          <p><strong>Date:</strong> ${reservationData.date}</p>
          <p><strong>Time:</strong> ${reservationData.time}</p>
          <p><strong>Guests:</strong> ${reservationData.guests}</p>
          <p><strong>Table:</strong> Table ${selectedTable.split('-')[1]}</p>
          ${reservationData.requests ? `<p><strong>Special Requests:</strong> ${reservationData.requests}</p>` : ''}
        </div>
        <p class="text-sm mt-3 text-green-600">Your reservation has been saved. We'll contact you if needed.</p>
      `;
      
      // Replace form with confirmation
      document.getElementById('reservationForm').style.display = 'none';
      document.querySelector('.bg-gradient-to-r.from-orange-50.to-amber-50').appendChild(successDiv);
      
      // Add "Make Another Reservation" button
      const anotherReservationBtn = document.createElement('button');
      anotherReservationBtn.className = 'w-full py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-all duration-300 mt-4';
      anotherReservationBtn.innerHTML = 'Make Another Reservation';
      anotherReservationBtn.onclick = function() {
        // Reset everything
        document.getElementById('reservationForm').style.display = 'block';
        document.getElementById('reservationForm').reset();
        selectedTable = null;
        updateTableDisplay();
        successDiv.remove();
        anotherReservationBtn.remove();
      };
      document.querySelector('.bg-gradient-to-r.from-orange-50.to-amber-50').appendChild(anotherReservationBtn);
      
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalText;
    }, 1500);
  });

  // Update table display when date changes
  document.getElementById('reservationDate').addEventListener('change', updateTableDisplay);
};</script>
  <style>
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
    .menu-item {
      animation: fadeInUp 0.6s ease-out forwards;
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
    /* Hero background using local image 'jm.webp' (fallback color included) */
    .hero-bg {
      position: relative;
      background-color: #f3f4f6; /* fallback light gray */
      background-image: url('fod.jpg');
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      color: white;
    }
    /* Overlay to improve text contrast over the image */
    .hero-bg::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom right, rgba(0,0,0,0.45), rgba(0,0,0,0.25));
      z-index: 0;
    }
    .filter-btn.active {
      background: #ff6b35;
      color: white;
      transform: scale(1.05);
    }
    

    .image-overlay {
      background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
    }

    /* Table Selection Styles */
    .table-item {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: linear-gradient(145deg, #ffffff, #f8fafc);
      border: 3px solid #e2e8f0;
      position: relative;
      overflow: hidden;
    }

    .table-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(145deg, rgba(255,255,255,0.8), rgba(248,250,252,0.8));
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .table-item:hover::before {
      opacity: 1;
    }

    .table-item.available {
      background: linear-gradient(145deg, #f0fdf4, #dcfce7);
      border-color: #22c55e;
      color: #15803d;
      box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
    }

    .table-item.available:hover {
      background: linear-gradient(145deg, #dcfce7, #bbf7d0);
      transform: scale(1.05) translateY(-2px);
      box-shadow: 0 8px 25px rgba(34, 197, 94, 0.25);
    }

    .table-item.reserved {
      background: linear-gradient(145deg, #fef2f2, #fecaca);
      border-color: #ef4444;
      color: #dc2626;
      cursor: not-allowed;
      opacity: 0.8;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
    }

    .table-item.reserved::after {
      content: '✕';
      position: absolute;
      top: 2px;
      right: 4px;
      font-size: 10px;
      font-weight: bold;
      color: #dc2626;
    }

    .table-item.selected {
      background: linear-gradient(145deg, #dbeafe, #bfdbfe);
      border-color: #3b82f6;
      color: #1d4ed8;
      transform: scale(1.1) translateY(-3px);
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2), 0 10px 30px rgba(59, 130, 246, 0.3);
      animation: pulse 2s infinite;
    }

    .table-item.selected:hover {
      background: linear-gradient(145deg, #bfdbfe, #93c5fd);
    }

    @keyframes pulse {
      0%, 100% {
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2), 0 10px 30px rgba(59, 130, 246, 0.3);
      }
      50% {
        box-shadow: 0 0 0 6px rgba(59, 130, 246, 0.1), 0 10px 30px rgba(59, 130, 246, 0.4);
      }
    }

    /* Restaurant table icon styling */
    .table-item svg {
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
  </style>
</head>
<body class="bg-amber-50 text-gray-800">
  <nav class="fixed top-0 w-full z-50 backdrop-blur-md bg-black/30 shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <a href="#" class="text-3xl  bg-gradient-warm bg-clip-text text-transparent font-extrabold">Big Bites</a>
        
        <!-- Navigation links -->
        <div class="hidden md:flex space-x-8">
          <a href="#home" class="text-white hover:text-orange-300 transition-colors duration-300 font-extrabold">Home</a>
          <a href="#menu" class="text-white hover:text-orange-300 transition-colors duration-300 font-extrabold">Menu</a>
          <a href="#about" class="text-white hover:text-orange-300 transition-colors duration-300 font-extrabold">About</a>
          <a href="#contact" class="text-white hover:text-orange-300 transition-colors duration-300 font-extrabold">Contact</a>
          <a href="login.php" class="text-white hover:text-orange-300 transition-colors duration-300 font-extrabold btn-login">Login</a>

        </div>

        
        <button 
          onclick="openReservationModal()"
          class="hidden md:block px-6 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-all duration-300 hover:scale-105 shadow-lg">
          Reserve Table
        </button>

        <!-- Reservation Modal -->
        <div id="reservationModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 display:flex items-start justify-center pt-8">
          <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl m-4 transform transition-all duration-300 scale-95 opacity-0 max-h-[90vh] overflow-y-auto" id="modalContent">
            <div class="p-6">
              <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Reserve Your Table</h3>
                <div class="flex items-center gap-3">
                  <button onclick="showReservations()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                    View Reservations
                  </button>
                  <button onclick="closeReservationModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </button>
                </div>
              </div>
              
              <div class="space-y-8">
                <!-- Reservation Form Section -->
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-6">
                  <h4 class="text-xl font-semibold text-gray-800 mb-6 text-center">Reservation Details</h4>
                  
                  <form id="reservationForm" class="space-y-6">
                    <!-- Name and Phone -->
                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="tel" name="phone" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                      </div>
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" id="reservationDate" name="date" required min="${new Date().toISOString().split('T')[0]}"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <select name="time" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                          <option value="">Select time</option>
                          <option value="11:00">11:00 AM</option>
                          <option value="12:00">12:00 PM</option>
                          <option value="13:00">1:00 PM</option>
                          <option value="14:00">2:00 PM</option>
                          <option value="17:00">5:00 PM</option>
                          <option value="18:00">6:00 PM</option>
                          <option value="19:00">7:00 PM</option>
                          <option value="20:00">8:00 PM</option>
                        </select>
                      </div>
                    </div>

                    <!-- Party Size -->
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Number of Guests</label>
                      <select name="guests" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="">Select number of guests</option>
                        <option value="1">1 Person</option>
                        <option value="2">2 People</option>
                        <option value="3">3 People</option>
                        <option value="4">4 People</option>
                        <option value="5">5 People</option>
                        <option value="6">6 People</option>
                        <option value="7+">7+ People</option>
                      </select>
                    </div>

                    <!-- Special Requests -->
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Special Requests (Optional)</label>
                      <textarea name="requests" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="Any special requests or dietary requirements?"></textarea>
                    </div>

                    <button type="submit"
                      class="w-full py-3 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-all duration-300 flex items-center justify-center gap-2">
                      <span>Confirm Reservation</span>
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                      </svg>
                    </button>
                  </form>
                </div>

                <!-- Table Selection Section -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                  <h4 class="text-xl font-semibold text-gray-800 mb-6 text-center">Select Your Table</h4>
                  
                  <!-- Table Layout -->
                  <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-8 shadow-inner">
                    <div class="flex justify-center">
                      <div class="grid grid-cols-4 gap-5 mb-8 max-w-md">
                        <!-- Table 1 -->
                        <div id="table-1" class="table-item w-20 h-20 rounded-xl border-3 border-gray-300 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 shadow-md" onclick="selectTable('table-1')">
                          <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          <span class="text-xs font-bold">1</span>
                        </div>
                        <!-- Table 2 -->
                        <div id="table-2" class="table-item w-20 h-20 rounded-xl border-3 border-gray-300 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 shadow-md" onclick="selectTable('table-2')">
                          <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          <span class="text-xs font-bold">2</span>
                        </div>
                        <!-- Table 3 -->
                        <div id="table-3" class="table-item w-20 h-20 rounded-xl border-3 border-gray-300 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 shadow-md" onclick="selectTable('table-3')">
                          <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          <span class="text-xs font-bold">3</span>
                        </div>
                        <!-- Table 4 -->
                        <div id="table-4" class="table-item w-20 h-20 rounded-xl border-3 border-gray-300 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 shadow-md" onclick="selectTable('table-4')">
                          <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          <span class="text-xs font-bold">4</span>
                        </div>
                        <!-- Table 5 -->
                        <div id="table-5" class="table-item w-20 h-20 rounded-xl border-3 border-gray-300 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 shadow-md" onclick="selectTable('table-5')">
                          <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          <span class="text-xs font-bold">5</span>
                        </div>
                        <!-- Table 6 -->
                        <div id="table-6" class="table-item w-20 h-20 rounded-xl border-3 border-gray-300 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 shadow-md" onclick="selectTable('table-6')">
                          <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          <span class="text-xs font-bold">6</span>
                        </div>
                        <!-- Table 7 -->
                        <div id="table-7" class="table-item w-20 h-20 rounded-xl border-3 border-gray-300 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 shadow-md" onclick="selectTable('table-7')">
                          <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          <span class="text-xs font-bold">7</span>
                        </div>
                        <!-- Table 8 -->
                        <div id="table-8" class="table-item w-20 h-20 rounded-xl border-3 border-gray-300 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 shadow-md" onclick="selectTable('table-8')">
                          <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          <span class="text-xs font-bold">8</span>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Legend -->
                    <div class="flex justify-center">
                      <div class="flex items-center gap-6 text-sm bg-white/80 backdrop-blur-sm rounded-lg px-4 py-3 shadow-sm">
                        <div class="flex items-center gap-2">
                          <div class="w-5 h-5 rounded-lg bg-gradient-to-br from-green-400 to-green-600 shadow-sm"></div>
                          <span class="font-medium text-gray-700">Available</span>
                        </div>
                        <div class="flex items-center gap-2">
                          <div class="w-5 h-5 rounded-lg bg-gradient-to-br from-red-400 to-red-600 shadow-sm"></div>
                          <span class="font-medium text-gray-700">Reserved</span>
                        </div>
                        <div class="flex items-center gap-2">
                          <div class="w-5 h-5 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 shadow-sm animate-pulse"></div>
                          <span class="font-medium text-gray-700">Selected</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Selected Table Info -->
                  <div id="selectedTableInfo" class="hidden mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl shadow-sm">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                      </div>
                      <span class="text-blue-800 font-semibold text-lg"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
         
        <!-- Mobile menu button -->
  <button class="md:hidden text-white">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>
  </nav>
  <section id="home" class="min-h-screen relative overflow-hidden">
    <!-- Full-screen video/image background -->
    <div class="absolute inset-0">
      <!-- Main background image with modern overlay -->
      <div class="absolute inset-0 bg-black">
        <img src="fod.jpg" alt="Restaurant Ambiance" class="w-full h-full object-cover opacity-70">
      </div>
      <!-- Gradient overlay -->
      <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-black/80"></div>
    </div>

    <!-- Main content -->
    <div class="relative z-10 flex flex-col justify-center items-center min-h-screen px-4 py-20">
      <!-- Center content wrapper -->
      <div class="max-w-6xl mx-auto text-center">
        <!-- Animated logo entrance -->
        <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
          <img src="logo big.png" alt="Big Bites Logo" class="w-32 md:w-40 mx-auto drop-shadow-2xl">
        </div>

        <!-- Main heading with gradient text -->
        <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">
          <span class="block text-white mb-2">Welcome to</span>
          <span class="block text-6xl md:text-8xl bg-gradient-warm bg-clip-text text-transparent">
            Big Bites
          </span>
        </h1>

        <!-- Tagline with elegant typography -->
        <p class="text-xl md:text-3xl text-white/90 font-light mb-8 max-w-2xl mx-auto">
          Where Every Bite Tells a Delicious Story
        </p>

        <!-- Description with subtle animation -->
        <p class="text-lg text-white/80 mb-12 max-w-xl mx-auto">
          Experience culinary excellence with our chef-crafted dishes
        </p>

        <!-- CTA Buttons with hover effects -->
        <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
          <!-- Order Now Button -->
          <a href="#menu" class="group relative px-8 py-4 bg-orange-500 text-white font-bold rounded-full overflow-hidden transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl w-64 md:w-auto">
            <span class="relative z-10 flex items-center justify-center gap-2">
              VIEW OUR MENU
              <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
          </a>

          <!-- Find Us Button -->
          <a href="#location" class="group px-8 py-4 bg-white/10 backdrop-blur text-white font-bold rounded-full hover:bg-white/20 transition-all duration-300 flex items-center gap-2 w-64 md:w-auto justify-center">
            <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            FIND US
          </a>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
          <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
          </svg>
        </div>
      </div>
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
        <button class="filter-btn active px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white hover:scale-105 transition-all duration-300">
          All
        </button>
        <button class="filter-btn px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white hover:scale-105 transition-all duration-300">
          Appetizers
        </button>
        <button class="filter-btn px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white hover:scale-105 transition-all duration-300">
          Main Course
        </button>
        <button class="filter-btn px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white hover:scale-105 transition-all duration-300">
          Desserts
        </button>
        <button class="filter-btn px-6 py-3 rounded-full bg-orange-100 text-orange-600 font-semibold hover:bg-orange-500 hover:text-white hover:scale-105 transition-all duration-300">
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
            <div class="w-full h-full bg-gradient-to-br  from-orange-400 to-red-500 flex items-center   "><img src="Brussata.webp" alt="Bruschetta">
              <svg class=" hover:scale-105 w-24 h-24  text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="w-full h-full bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center"><img src="salmon.jpg" alt="Salmon">
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
              <span class="text-2xl font-bold text-orange-500">$30</span>
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
            <div class="w-full h-full bg-gradient-to-br flex items-center justify-center"><img src="Tiramisu.jpg" alt="">
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
              <span class="text-2xl font-bold text-orange-500">$15
                
              </span>
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
        <!-- Menu Item 4 -->
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
            <p class="text-gray-600 mb-4">Cha Kdao is a popular Cambodian stir-fry dish featuring holy basil, chili, garlic, and meat—typically chicken</p>

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
  <!-- EXPLANATION: About Section with modern layout -->
  <section id="about" class="py-24 bg-white relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 opacity-5">
      <div class="absolute top-20 left-10 w-72 h-72 bg-orange-500 rounded-full filter blur-3xl"></div>
      <div class="absolute bottom-20 right-10 w-96 h-96 bg-yellow-500 rounded-full filter blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
      <!-- Section header -->
      <div class="text-center mb-16">
        <h2 class="text-5xl md:text-6xl font-bold mb-4">
          About <span class="bg-gradient-warm bg-clip-text text-transparent">Our Story</span>
        </h2>
        <div class="w-24 h-1 bg-gradient-warm mx-auto mb-8 rounded-full"></div>
      </div>

      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <!-- Content column -->
        <div class="space-y-8">
          <div class="bg-orange-50 p-8 rounded-3xl shadow-xl transform hover:-translate-y-1 transition-transform duration-300">
            <h3 class="text-2xl font-bold mb-4 text-gray-800">Our Heritage</h3>
            <p class="text-gray-600 leading-relaxed">
              Founded in 2020, Big Bites has become a beloved destination for food enthusiasts seeking exceptional dining experiences. Our passionate chefs combine traditional techniques with modern innovation to create unforgettable flavors.
            </p>
          </div>

          <div class="bg-orange-50 p-8 rounded-3xl shadow-xl transform hover:-translate-y-1 transition-transform duration-300">
            <h3 class="text-2xl font-bold mb-4 text-gray-800">Our Promise</h3>
            <p class="text-gray-600 leading-relaxed">
              We source ingredients from local farms and artisans, ensuring every dish is fresh, sustainable, and bursting with flavor. Our commitment to quality and hospitality makes every visit special.
            </p>
          </div>
          <!-- Stats grid -->
          <div class="grid grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform hover:-translate-y-1 transition-transform duration-300">
              <div class="text-4xl font-bold bg-gradient-warm bg-clip-text text-transparent mb-2">2000+</div>
              <div class="text-gray-600">Happy Customers</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform hover:-translate-y-1 transition-transform duration-300">
              <div class="text-4xl font-bold bg-gradient-warm bg-clip-text text-transparent mb-2">20+</div>
              <div class="text-gray-600">Menu Items</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform hover:-translate-y-1 transition-transform duration-300">
              <div class="text-4xl font-bold bg-gradient-warm bg-clip-text text-transparent mb-2">7.7</div>
              <div class="text-gray-600">Rating</div>
            </div>
          </div>
        </div>
        
        <!-- Image column -->
        <div class="relative group">
          <!-- Main image container -->
          <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl transform group-hover:-translate-y-2 transition-transform duration-500">
            <img src="Näsinneula.jpg"  alt="Our Restaurant" class="w-full h-[600px] object-cover">
            <!-- Gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>
          </div>
          
          <!-- Decorative elements -->
          <div class="absolute inset-0 z-0 rounded-3xl bg-gradient-warm blur-2xl opacity-20 transform group-hover:scale-105 transition-transform duration-500"></div>
          
          <!-- Image caption -->
          <div class="absolute bottom-8 left-8 right-8 text-white z-20">
            <h3 class="text-2xl font-bold mb-2">A Taste of Tradition</h3>
            <p class="text-white/90">Where every meal tells a story of passion and heritage</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Location Section -->
  <section id="location" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <h2 class="text-5xl md:text-6xl font-bold mb-4">
          Find <span class="bg-gradient-warm bg-clip-text text-transparent">Us</span>
        </h2>
        <div class="w-24 h-1 bg-gradient-warm mx-auto mb-8 rounded-full"></div>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
          Come visit us and experience the perfect blend of flavor and ambiance
        </p>
      </div>

      <div class="grid lg:grid-cols-2 gap-12 items-start">
        <!-- Map Section -->
        <div class="rounded-3xl overflow-hidden shadow-2xl h-[500px] relative group">
          <iframe>
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.7714081333476!2d104.88639661481548!3d11.568290991785754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310951add5e2cd81%3A0x171e0b69c7c6f7ba!2sCAMPUS!5e0!3m2!1sen!2skh!4v1635464329246!5m2!1sen!2skh"
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy"
            class="group-hover:scale-105 transition-transform duration-500"
          ></iframe>
          <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
        </div>

        <!-- Info Section -->
        <div class="space-y-8">
          <!-- Address Card -->
          <div class="bg-white p-8 rounded-3xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center gap-4 mb-4">
              <div class="bg-orange-500 p-3 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-800 mb-1">Our Location</h3>
                <p class="text-gray-600">123 Foodie Street, Cuisine District</p>
                <p class="text-gray-600">Phnom Penh, Cambodia</p>
              </div>
            </div>
            <a href="https://goo.gl/maps/your-location" target="_blank" class="inline-flex items-center gap-2 text-orange-500 hover:text-orange-600 font-medium">
              <span>Get Directions</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </a>
          </div>

          <!-- Hours Card -->
          <div class="bg-white p-8 rounded-3xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center gap-4 mb-6">
              <div class="bg-orange-500 p-3 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <h3 class="text-xl font-bold text-gray-800">Opening Hours</h3>
            </div>
            <div class="grid grid-cols-2 gap-4 text-gray-600">
              <div>
                <p class="font-medium">Monday - Friday</p>
                <p>10:00 AM - 10:00 PM</p>
              </div>
              <div>
                <p class="font-medium">Saturday - Sunday</p>
                <p>11:00 AM - 11:00 PM</p>
              </div>
            </div>
          </div>

          <!-- Contact Card -->
          <div class="bg-white p-8 rounded-3xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center gap-4 mb-6">
              <div class="bg-orange-500 p-3 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
              </div>
              <h3 class="text-xl font-bold text-gray-800">Quick Contact</h3>
            </div>
            <div class="space-y-4 text-gray-600">
              <p class="flex items-center gap-2">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>info@bigbites.com</span>
              </p>
              <p class="flex items-center gap-2">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>+855 88 381 7532</span>
              </p>
            </div>
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

  <footer class="text-center text-gray-500 py-6">©Created by nithhhh</footer>

</body>
</html>
