<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Listar todas las facturas
    public function index()
    {
        $invoices = Sale::where('is_invoiced', true)->get();
        return view('invoices.index', compact('invoices'));
    }

    // Mostrar los detalles de una factura
    public function show(Sale $sale)
    {
        return view('invoices.show', compact('sale'));
    }

    // Generar factura electrónica
    public function generate(Sale $sale)
    {
        // Lógica para generar la factura electrónica usando la API
        // ...

        $sale->is_invoiced = true;
        $sale->save();

        return redirect()->route('invoices.show', $sale)->with('success', 'Factura generada correctamente.');
    }
}