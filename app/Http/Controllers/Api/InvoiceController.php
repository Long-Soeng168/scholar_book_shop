<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Notification;
use App\Notifications\MyTelegramBotNotification;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        // return response()->json($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:books,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate the total, subtotal, and shipping (example)
        $subtotal = 0;
        foreach ($request->items as $item) {
            $afterDiscount = $item['price'] - ($item['discount'] / 100) * $item['price'];
            $subtotal += $afterDiscount * $item['quantity'];
        }

        $shipping = 0.00;
        $total = $subtotal + $shipping;

        // Create the invoice
        $invoice = Invoice::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'note' => $validated['note'] ?? null,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
        ]);
        // $invoice = Invoice::create([
        //     'name' => $validated['name'],
        //     'phone' => $validated['phone'],
        //     'note' => $validated['note'] ?? null,
        //     'subtotal' => 1,
        //     'shipping' => 1,
        //     'total' => 1,
        // ]);

        // Create the invoice items
        foreach ($request->items as $item) {
            $createdItem = InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['id'],
                'title' => $item['title'],
                'image' => $item['image'],
                'discount' => $item['discount'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // try {
        // Notification::route('telegram', config('services.telegram_chat_id'))
        //         ->notify(new MyTelegramBotNotification($invoice));
        // } catch (\Exception $e) {
        //     // Log::error('Notification failed: ' . $e->getMessage());
        // }

        return response()->json(['message' => 'Invoice created successfully', 'invoice' => $invoice], 201);
    }
}
