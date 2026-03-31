<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - NexStock</title>
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
                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">ADMIN</span>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/admin" class="text-slate-600 hover:text-slate-900 transition-colors">Dashboard</a>
                    <a href="/admin/items" class="text-slate-600 hover:text-slate-900 transition-colors">Items</a>
                    <a href="/admin/categories" class="text-indigo-600 font-medium hover:text-indigo-700 transition-colors">Categories</a>
                    <a href="/admin/transactions" class="text-slate-600 hover:text-slate-900 transition-colors">
                        <i class="fas fa-exchange-alt mr-1"></i>Transaksi
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
                            <p class="text-xs text-indigo-600 font-medium">Admin ID: {{ auth()->user()->id_admin }}</p>
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
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Manajemen Kategori</h1>
                <p class="text-slate-600 mt-1">Kelola kategori untuk mengorganisir barang</p>
            </div>
            <a href="/admin" class="bg-slate-600 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Add Category Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Tambah Kategori Baru</h2>
                        <i class="fas fa-plus-circle text-indigo-600 text-xl"></i>
                    </div>
                    
                    <form action="/admin/categories" method="POST" class="space-y-4">
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
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-slate-900"
                                   value="{{ old('name') }}" placeholder="Contoh: Elektronik">
                        </div>

                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-4 py-2.5 rounded-lg hover:from-indigo-700 hover:to-violet-700 transition-all duration-200 font-medium text-sm shadow-sm hover:shadow-md">
                            <i class="fas fa-plus mr-2"></i>Tambah Kategori
                        </button>
                    </form>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-slate-900">Daftar Kategori</h2>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-slate-500">{{ $categories->count() }} kategori</span>
                        </div>
                    </div>
                    
                    @if($categories->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">No</th>
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Nama Kategori</th>
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Jumlah Barang</th>
                                        <th class="text-left py-3 px-4 text-xs font-medium text-slate-600 uppercase tracking-wider">Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($categories as $index => $category)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-3 px-4 text-sm text-slate-900 font-medium">{{ $index + 1 }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-tags text-green-600 text-xs"></i>
                                                    </div>
                                                    <span class="text-sm font-medium text-slate-900">{{ $category->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $category->items->count() }} barang
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-slate-600">
                                                {{ $category->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tags text-slate-400 text-2xl"></i>
                            </div>
                            <h3 class="text-sm font-medium text-slate-900 mb-1">Belum ada data kategori</h3>
                            <p class="text-sm text-slate-500">Mulai dengan menambahkan kategori baru.</p>
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

        // Auto-hide flash messages after 3 seconds
        setTimeout(function() {
            const flashMessages = document.querySelectorAll('.fixed.top-20.right-4 > div');
            flashMessages.forEach(function(message) {
                message.style.display = 'none';
            });
        }, 3000);
    </script>
</body>
</html>
