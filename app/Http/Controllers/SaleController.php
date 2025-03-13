<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('client', 'user', 'saleDetails.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
{
    $products = Product::all(); // Asegúrate de que esto devuelva una colección válida
    return view('sales.create', compact('products'));
}
public function store(Request $request)
{
    $validated = $request->validate([
        'payment_method' => 'required|in:efectivo,tarjeta,transferencia',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.price' => 'required|numeric|min:0',
        'cash_received' => 'required_if:payment_method,efectivo|numeric|min:0',
    ]);

    $sale = new Sale();
    $sale->user_id = auth()->id();
    $sale->client_id = null; // Asigna null si es nullable, o un ID de cliente válido
    $sale->payment_method = $request->payment_method;
    $sale->total = 0;
    $sale->tax = 0;
    $sale->sale_date = now();
    $sale->status = 'completed';
    $sale->save();

    $total = 0;
    $subtotal = 0;
    foreach ($request->products as $productData) {
        $product = Product::findOrFail($productData['product_id']);
        $quantity = $productData['quantity'];
        $price = $productData['price'];

        if ($product->stock < $quantity) {
            return back()->withErrors(['products' => "El producto {$product->name} no tiene suficiente stock."]);
        }

        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale->id;
        $saleDetail->product_id = $product->id;
        $saleDetail->quantity = $quantity;
        $saleDetail->price = $price;
        $saleDetail->subtotal = $quantity * $price;
        $saleDetail->save();

        $product->stock -= $quantity;
        $product->save();

        $subtotal += $saleDetail->subtotal;
    }

    $tax = $subtotal * 0.19;
    $total = $subtotal + $tax;

    $sale->total = $total;
    $sale->tax = $tax;
    $sale->save();

    return redirect()->route('sales.show', $sale->id)
        ->with('success', 'Venta creada con éxito. Puede imprimir la factura ahora.');
}
        public function show(Sale $sale)
    {
        $sale->load('client', 'user', 'saleDetails.product');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $clients = Client::all();
        $products = Product::where('stock', '>', 0)->get();
        $users = User::all();
        $sale->load('saleDetails.product');
        return view('sales.edit', compact('sale', 'clients', 'products', 'users'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'payment_method' => 'required|in:efectivo,tarjeta,transferencia',
            'tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Restaurar stock de productos anteriores
        foreach ($sale->saleDetails as $detail) {
            $product = $detail->product;
            $product->stock += $detail->quantity;
            $product->save();
        }

        $sale->update([
            'client_id' => $request->client_id,
            'tax' => $request->tax,
            'discount' => $request->discount,
            'payment_method' => $request->payment_method,
        ]);

        $sale->saleDetails()->delete();
        $subtotal = 0;
        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);
            if ($product->stock < $item['quantity']) {
                return redirect()->back()->withErrors(['products' => "No hay suficiente stock para {$product->name}"]);
            }
            $itemSubtotal = $product->price * $item['quantity'];
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $itemSubtotal,
            ]);
            $subtotal += $itemSubtotal;
            $product->stock -= $item['quantity'];
            $product->save();
        }

        $total = $subtotal + $request->tax - $request->discount;
        $sale->update(['total' => $total]);

        return redirect()->route('sales.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Sale $sale)
    {
        foreach ($sale->saleDetails as $detail) {
            $product = $detail->product;
            $product->stock += $detail->quantity;
            $product->save();
        }
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venta eliminada correctamente.');
    }

    public function export()
    {
        $sales = Sale::with('client', 'saleDetails.product')->get();
        $filename = 'ventas_' . now()->format('YmdHis') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($sales) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Cliente', 'Total', 'Impuesto', 'Descuento', 'Método de Pago', 'Facturada', 'Estado', 'Fecha']);

            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->id,
                    $sale->client->name ?? 'Sin cliente',
                    $sale->total,
                    $sale->tax,
                    $sale->discount,
                    $sale->payment_method,
                    $sale->is_invoiced ? 'Sí' : 'No',
                    $sale->status,
                    $sale->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
    public function cancel($id)
{
    $sale = Sale::findOrFail($id);

    // Lógica para cancelar la venta
    $sale->status = 'cancelled'; // Cambiar el estado a "cancelled"
    $sale->save();

    // Revertir el stock de los productos
    foreach ($sale->saleDetails as $detail) {
        $product = $detail->product;
        $product->stock += $detail->quantity;
        $product->save();
    }

    return redirect()->route('sales.index')->with('success', 'La venta ha sido cancelada con éxito.');
}
}