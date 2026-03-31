<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $items = Item::with('category')->latest()->get();
        $categories = Category::all();
        
        // Calculate statistics
        $totalItems = $items->count();
        $totalCategories = $categories->count();
        $totalAssetValue = $items->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        return view('admin.dashboard', compact('items', 'categories', 'totalItems', 'totalCategories', 'totalAssetValue'));
    }

    /**
     * Display items management page.
     */
    public function items()
    {
        $items = Item::with('category')->latest()->get();
        $categories = Category::all();
        
        return view('admin.items', compact('items', 'categories'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:80',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'photo' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama barang wajib diisi',
            'name.min' => 'Nama barang minimal 5 karakter',
            'name.max' => 'Nama barang maksimal 80 karakter',
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'price.required' => 'Harga wajib diisi',
            'price.integer' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh negatif',
            'quantity.required' => 'Jumlah barang wajib diisi',
            'quantity.integer' => 'Jumlah barang harus berupa angka',
            'quantity.min' => 'Jumlah barang tidak boleh negatif',
            'photo.required' => 'Foto barang wajib diisi',
            'photo.max' => 'URL foto maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/items')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambahkan barang. Periksa kembali input Anda.');
        }

        try {
            Item::create($request->all());
            
            return redirect('/admin/items')
                ->with('success', 'Barang berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect('/admin/items')
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan barang.');
        }
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        
        return view('admin.items_edit', compact('item', 'categories'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:80',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'photo' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama barang wajib diisi',
            'name.min' => 'Nama barang minimal 5 karakter',
            'name.max' => 'Nama barang maksimal 80 karakter',
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'price.required' => 'Harga wajib diisi',
            'price.integer' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh negatif',
            'quantity.required' => 'Jumlah barang wajib diisi',
            'quantity.integer' => 'Jumlah barang harus berupa angka',
            'quantity.min' => 'Jumlah barang tidak boleh negatif',
            'photo.required' => 'Foto barang wajib diisi',
            'photo.max' => 'URL foto maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal mengupdate barang. Periksa kembali input Anda.');
        }

        try {
            $item = Item::findOrFail($id);
            $item->update($request->all());
            
            return redirect('/admin/items')
                ->with('success', 'Barang berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate barang.');
        }
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();
            
            return redirect('/admin/items')
                ->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/admin/items')
                ->with('error', 'Terjadi kesalahan saat menghapus barang.');
        }
    }

    /**
     * Display categories management page.
     */
    public function categories()
    {
        $categories = Category::latest()->get();
        
        return view('admin.categories', compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
            'name.max' => 'Nama kategori maksimal 255 karakter',
            'name.unique' => 'Nama kategori sudah ada',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/categories')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambahkan kategori. Periksa kembali input Anda.');
        }

        try {
            Category::create($request->all());
            
            return redirect('/admin/categories')
                ->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect('/admin/categories')
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan kategori.');
        }
    }

    /**
     * Display all transactions for admin.
     */
    public function transactions()
    {
        $invoices = Invoice::with('user', 'items')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.transactions', compact('invoices'));
    }

    /**
     * Display the invoice/print page with all items.
     */
    public function printInvoice()
    {
        $items = Item::with('category')->orderBy('category_id')->orderBy('name')->get();
        $categories = Category::all();
        
        // Calculate statistics for report
        $totalItems = $items->count();
        $totalCategories = $categories->count();
        $totalAssetValue = $items->sum(function($item) {
            return $item->price * $item->quantity;
        });
        $totalQuantity = $items->sum('quantity');
        
        return view('admin.invoice', compact('items', 'categories', 'totalItems', 'totalCategories', 'totalAssetValue', 'totalQuantity'));
    }
}
