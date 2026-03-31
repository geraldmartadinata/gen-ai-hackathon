<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexStock - Sistem Inventaris Modern</title>
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
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-indigo-600 font-medium hover:text-indigo-700 transition-colors">Dashboard</a>
                    <a href="#" class="text-slate-600 hover:text-slate-900 transition-colors">Items</a>
                    <a href="#" class="text-slate-600 hover:text-slate-900 transition-colors">Categories</a>
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
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Items Card -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Total Barang</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalItems }}</p>
                        <p class="text-xs text-slate-500 mt-1">items in inventory</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-blue-600 text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Total Categories Card -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Total Kategori</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalCategories }}</p>
                        <p class="text-xs text-slate-500 mt-1">categories available</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tags text-green-600 text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Total Asset Value Card -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Total Nilai Aset</p>
                        <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-500 mt-1">total inventory value</p>
                    </div>
                    <div class="w-12 h-12 bg-violet-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-violet-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Add Item Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Tambah Barang Baru</h2>
                        <i class="fas fa-plus-circle text-indigo-600 text-xl"></i>
                    </div>
                    
                    <form action="/dashboard" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-lg text-sm">
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
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Barang</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                   value="{{ old('name') }}" placeholder="Masukkan nama barang">
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                            <select id="category_id" name="category_id" required
                                    class="w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="price" class="block text-sm font-medium text-slate-700 mb-2">Harga</label>
                                <input type="number" id="price" name="price" required min="0"
                                       class="w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                       value="{{ old('price') }}" placeholder="0">
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-slate-700 mb-2">Quantity</label>
                                <input type="number" id="quantity" name="quantity" required min="0"
                                       class="w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                       value="{{ old('quantity') }}" placeholder="0">
                            </div>
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-medium text-slate-700 mb-2">Photo URL (opsional)</label>
                            <input type="text" id="photo" name="photo"
                                   class="w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                   value="{{ old('photo') }}" placeholder="https://example.com/photo.jpg">
                        </div>

                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-4 py-2.5 rounded-lg hover:from-indigo-700 hover:to-violet-700 transition-all duration-200 font-medium text-sm shadow-sm hover:shadow-md">
                            <i class="fas fa-plus mr-2"></i>Tambah Barang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Items Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Daftar Barang</h2>
                        <div class="flex items-center space-x-3">
                            <a href="/print/invoice" target="_blank" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                                <i class="fas fa-print mr-2"></i>Cetak Laporan
                            </a>
                            <span class="text-sm text-slate-500">{{ $items->count() }} items</span>
                            <button class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    
                    @if($items->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">No</th>
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Nama Barang</th>
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Kategori</th>
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Harga</th>
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Quantity</th>
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Photo</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($items as $index => $item)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-3 px-4 text-sm text-slate-900 font-medium">{{ $index + 1 }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-violet-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-box text-indigo-600 text-xs"></i>
                                                    </div>
                                                    <span class="text-sm font-medium text-slate-900">{{ $item->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $item->category->name }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-slate-900 font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="py-3 px-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->quantity > 10 ? 'bg-green-100 text-green-800' : ($item->quantity > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $item->quantity }} units
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                @if($item->photo)
                                                    <img src="{{ $item->photo }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                                @else
                                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                                                        <i class="fas fa-image text-slate-400 text-xs"></i>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                            </div>
                            <h3 class="text-sm font-medium text-slate-900 mb-1">Belum ada data barang</h3>
                            <p class="text-sm text-slate-500">Mulai dengan menambahkan barang baru.</p>
                        </div>
                    @endif
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
