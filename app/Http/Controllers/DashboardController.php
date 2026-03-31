<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with items and categories.
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
        
        return view('dashboard', compact('items', 'categories', 'totalItems', 'totalCategories', 'totalAssetValue'));
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
        
        return view('invoice', compact('items', 'categories', 'totalItems', 'totalCategories', 'totalAssetValue', 'totalQuantity'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'photo' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambahkan barang. Periksa kembali input Anda.');
        }

        try {
            Item::create($request->all());
            
            return redirect('/')
                ->with('success', 'Barang berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect('/')
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan barang.');
        }
    }
}
