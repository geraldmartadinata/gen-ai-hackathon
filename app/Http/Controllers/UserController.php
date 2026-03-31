<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display the user catalog.
     */
    public function index()
    {
        $items = Item::with('category')->latest()->get();
        $categories = Category::all();
        
        return view('user.catalog', compact('items', 'categories'));
    }

    /**
     * Add item to cart.
     */
    public function addToCart(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        
        // Check if item is out of stock
        if ($item->quantity == 0) {
            return redirect()->back()
                ->with('error', 'Barang sudah habis, silakan tunggu hingga barang di-restock ulang');
        }

        // Get current cart from session
        $cart = Session::get('cart', []);
        
        // Check if adding would exceed stock
        $currentQuantity = isset($cart[$itemId]) ? $cart[$itemId]['quantity'] : 0;
        if ($currentQuantity >= $item->quantity) {
            return redirect()->back()
                ->with('error', 'Jumlah melebihi stok yang tersedia');
        }
        
        // Add item to cart or update quantity
        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] += 1;
        } else {
            $cart[$itemId] = [
                'id' => $item->id,
                'name' => $item->name,
                'category' => $item->category->name,
                'price' => $item->price,
                'quantity' => 1,
                'photo' => $item->photo
            ];
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()
            ->with('success', 'Barang berhasil ditambahkan ke keranjang');
    }

    /**
     * Display cart page.
     */
    public function cart()
    {
        $cart = Session::get('cart', []);
        
        return view('user.cart', compact('cart'));
    }

    /**
     * Update cart quantity.
     */
    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $itemId = $request->input('item_id');
        $quantity = $request->input('quantity');
        
        if (isset($cart[$itemId]) && $quantity > 0) {
            // Check if quantity exceeds stock
            $item = Item::findOrFail($itemId);
            if ($quantity > $item->quantity) {
                return redirect('/user/cart')
                    ->with('error', 'Jumlah melebihi stok yang tersedia');
            }
            
            $cart[$itemId]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }
        
        return redirect('/user/cart')
            ->with('success', 'Keranjang berhasil diperbarui');
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart($itemId)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            Session::put('cart', $cart);
        }
        
        return redirect('/user/cart')
            ->with('success', 'Barang berhasil dihapus dari keranjang');
    }

    /**
     * Clear cart.
     */
    public function clearCart()
    {
        Session::forget('cart');
        
        return redirect('/user/cart')
            ->with('success', 'Keranjang berhasil dikosongkan');
    }

    /**
     * Display invoice creation page.
     */
    public function createInvoice()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect('/user/cart')
                ->with('error', 'Keranjang belanja Anda kosong');
        }
        
        return view('user.invoice', compact('cart'));
    }

    /**
     * Display order history for the current user.
     */
    public function history()
    {
        $invoices = Invoice::where('user_id', Auth::id())
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.history', compact('invoices'));
    }

    /**
     * Store invoice data.
     */
    public function storeInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string|min:10|max:100',
            'postal_code' => 'required|string|digits:5',
        ], [
            'shipping_address.required' => 'Alamat pengiriman wajib diisi',
            'shipping_address.min' => 'Alamat pengiriman minimal 10 karakter',
            'shipping_address.max' => 'Alamat pengiriman maksimal 100 karakter',
            'postal_code.required' => 'Kode pos wajib diisi',
            'postal_code.digits' => 'Kode pos harus tepat 5 digit angka',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data faktur tidak valid. Periksa kembali input Anda.');
        }

        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect('/user/cart')
                ->with('error', 'Keranjang belanja Anda kosong');
        }

        try {
            // Generate invoice number
            $invoiceNumber = 'INV/' . date('Ymd') . '/' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            
            // Calculate total
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Create invoice record
            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => Auth::id(),
                'shipping_address' => $request->shipping_address,
                'postal_code' => $request->postal_code,
                'total_price' => $total,
            ]);

            // Attach items to invoice and reduce stock
            foreach ($cart as $itemId => $item) {
                $itemModel = Item::findOrFail($itemId);
                
                // Check if stock is sufficient
                if ($itemModel->quantity < $item['quantity']) {
                    // Delete the created invoice and return error
                    $invoice->delete();
                    return redirect('/user/cart')
                        ->with('error', 'Stok barang "' . $item['name'] . '" tidak mencukupi. Stok tersedia: ' . $itemModel->quantity);
                }
                
                // Attach item to invoice with pivot data
                $invoice->items()->attach($itemId, [
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);
                
                // Reduce stock
                $itemModel->quantity -= $item['quantity'];
                $itemModel->save();
            }
            
            // Clear cart after successful invoice creation
            Session::forget('cart');
            
            return view('user.invoice_print', compact('cart', 'invoiceNumber', 'total', 'request'));
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat faktur.');
        }
    }
}
