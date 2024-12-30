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

    public function holds(Request $request)
    {
        $items = Invoice::where('status', 0)->with('items', 'customer')->get();
        return response()->json($items);
    }
    public function delete($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->delete();
            return response()->json(['message' => 'delete success'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Invoice not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the invoice'], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        // return response()->json($request->all());
        $validated = $request->validate([
            'customerId' => 'nullable',
            'paymentTypeId' => 'nullable',
            'discount' => 'nullable',
            'discountType' => 'nullable',
            'subtotal' => 'nullable',
            'total' => 'nullable',
            'total_recieved_dollar' => 'nullable',
            'exchange_rate' => 'nullable',
            'userId' => 'required|exists:users,id',
            'note' => 'nullable',
            'status' => 'nullable',
            'items' => 'required|array',
        ]);

        // Create the invoice
        $invoice = Invoice::create([
            'customerId' => $validated['customerId'] ?? null,
            'paymentTypeId' => $validated['paymentTypeId'] ?? null,
            'discount' => $validated['discount'] ?? 0,
            'discountType' => $validated['discountType'] ?? null,
            'subtotal' => $validated['subtotal'] ?? 0,
            'total' => $validated['total'] ?? 0,
            'total_recieved_dollar' => $validated['total_recieved_dollar'] ?? 0,
            'exchange_rate' => $validated['exchange_rate'] ?? null,
            'userId' => $validated['userId'] ?? 0,
            'status' => $validated['status'] ?? 0,
            'note' => $validated['note'] ?? null,
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

        return response()->json(['message' => 'Invoice created successfully', 'invoice' => $invoice->load('items', 'customer', 'payment')], 201);
    }
}
