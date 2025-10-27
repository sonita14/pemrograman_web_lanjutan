<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
        ]);

        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'whatsapp' => $request->whatsapp,
            'total' => $total,
            'status' => 'pending'
        ]);

        foreach($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            // Update stock
            $product = Product::find($id);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        // Generate WhatsApp message
        $message = $this->generateWhatsAppMessage($order);
        
        // Clear cart
        session()->forget('cart');

        return redirect()->route('order.success', ['order' => $order->id, 'message' => urlencode($message)]);
    }

    public function success($order)
    {
        $order = Order::with('orderItems.product')->findOrFail($order);
        $message = request()->get('message');
        return view('order-success', compact('order', 'message'));
    }

    private function generateWhatsAppMessage($order)
    {
        $order->load('orderItems.product');
        
        $message = "*TOKO BIRU - Konfirmasi Pesanan*\n\n";
        $message .= "Halo *{$order->customer_name}*!\n\n";
        $message .= "Terima kasih telah berbelanja di Toko Biru.\n\n";
        $message .= "*Detail Pesanan #" . $order->id . "*\n";
        $message .= "─────────────────\n";
        
        foreach($order->orderItems as $item) {
            $message .= "• " . $item->product->name . "\n";
            $message .= "  Jumlah: " . $item->quantity . " x Rp " . number_format($item->price, 0, ',', '.') . "\n";
            $message .= "  Subtotal: Rp " . number_format($item->quantity * $item->price, 0, ',', '.') . "\n\n";
        }
        
        $message .= "─────────────────\n";
        $message .= "*Total: Rp " . number_format($order->total, 0, ',', '.') . "*\n\n";
        $message .= "Kami akan segera menghubungi Anda untuk konfirmasi pembayaran dan pengiriman.\n\n";
        $message .= "Terima kasih! 🙏";
        
        return $message;
    }
}