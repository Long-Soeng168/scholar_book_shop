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
            'customerId' => 'nullable',
            'paymentTypId' => 'nullable',
            'discount' => 'nullable',
            'discountType' => 'nullable',
            'total' => 'nullable',
            'userId' => 'required|exists:users,id',
            'items' => 'required|array',
        ]);

        // Create the invoice
        $invoice = Invoice::create([
            'customerId' => $validated['customerId'] ?? null,
            'paymentTypId' => $validated['paymentTypId'] ?? null,
            'total' => $validated['total'] ?? 0,
            'userId' => $validated['userId'] ?? 0,
        ]);

        foreach ($validated['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['id'],
                'title' => $item['title'] ?? '',
                'image' => $item['image'] ?? '',
                'discount' => $item['discount'] ?? 0,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'type' => $item['type'] ?? null,
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
