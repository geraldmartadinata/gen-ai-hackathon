<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Faktur - NexStock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <!-- Modern Sticky Navbar -->
    <nav class="sticky top-0 z-50 bg-white border-b border-slate-200 backdrop-blur-lg bg-opacity-95">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-xl text-slate-900">NexStock</span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">USER</span>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/user" class="text-slate-600 hover:text-slate-900 transition-colors">Katalog</a>
                    <a href="/user/cart" class="text-slate-600 hover:text-slate-900 transition-colors relative">
                        <i class="fas fa-shopping-cart mr-1"></i>Keranjang
                        @if($cart && count($cart) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ count($cart) }}
                            </span>
                        @endif
                    </a>
                    <a href="/user/history" class="text-slate-600 hover:text-slate-900 transition-colors">
                        <i class="fas fa-history mr-1"></i>Riwayat
                    </a>
                    <a href="/user/invoice" class="text-indigo-600 font-medium hover:text-indigo-700 transition-colors">
                        <i class="fas fa-file-invoice mr-1"></i>Faktur
                    </a>
                </div>

                <!-- User Profile -->
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 cursor-pointer group hover:bg-slate-50 rounded-lg px-3 py-2 transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-slate-400 text-xs group-hover:text-slate-600 transition-colors"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fas fa-user-circle mr-2"></i>Profil
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fas fa-cog mr-2"></i>Pengaturan
                        </a>
                        <form action="/logout" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
        <div class="fixed top-20 right-4 z-50 max-w-sm">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle text-green-600"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-600 hover:text-green-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Buat Faktur</h1>
            <p class="text-slate-600">Lengkapi data pengiriman untuk membuat faktur pembelian</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-6">Ringkasan Pesanan</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cart as $item)
                            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    @if($item['photo'])
                                        <img src="{{ $item['photo'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                                    @else
                                        <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                                            <i class="fas fa-box text-slate-400 text-xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-slate-900">{{ $item['name'] }}</h3>
                                        <p class="text-sm text-slate-600">{{ $item['category'] }}</p>
                                        <p class="text-sm text-slate-500">Rp {{ number_format($item['price'], 0, ',', '.') }} × {{ $item['quantity'] }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-slate-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="border-t border-slate-200 pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-slate-600">Subtotal:</span>
                            <span class="font-medium text-slate-900">Rp {{ number_format(collect($cart)->sum(function($item) { return $item['price'] * $item['quantity']; }), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-slate-900">Total:</span>
                            <span class="text-xl font-bold text-indigo-600">Rp {{ number_format(collect($cart)->sum(function($item) { return $item['price'] * $item['quantity']; }), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-6">Informasi Pengiriman</h2>
                    
                    <form action="/user/invoice/store" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-lg text-sm mb-4">
                                <div class="flex items-center space-x-2 mb-1">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span class="font-medium">Perhatian:</span>
                                </div>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-slate-700 mb-2">Alamat Pengiriman</label>
                            <textarea id="shipping_address" name="shipping_address" required rows="4"
                                      class="w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                      placeholder="Masukkan alamat lengkap pengiriman">{{ old('shipping_address') }}</textarea>
                            <p class="text-xs text-slate-500 mt-1">Minimal 10 karakter, maksimal 100 karakter</p>
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
                            <input type="text" id="postal_code" name="postal_code" required maxlength="5"
                                   class="w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                   placeholder="12345" value="{{ old('postal_code') }}">
                            <p class="text-xs text-slate-500 mt-1">Harus tepat 5 digit angka</p>
                        </div>

                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-4 py-2.5 rounded-lg hover:from-indigo-700 hover:to-violet-700 transition-all duration-200 font-medium text-sm shadow-sm hover:shadow-md">
                            <i class="fas fa-file-invoice mr-2"></i>Buat Faktur
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Modern Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="w-6 h-6 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-md flex items-center justify-center">
                        <i class="fas fa-box text-white text-xs"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-900">NexStock</span>
                    <span class="text-sm text-slate-500">© {{ date('Y') }} All rights reserved.</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Privacy</a>
                    <a href="#" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Terms</a>
                    <a href="#" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Support</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toggle dropdown menu
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button[onclick="toggleDropdown()"]');
            
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
