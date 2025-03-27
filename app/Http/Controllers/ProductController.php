<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\Facades\DNS1DFacade;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'supplier')->active();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'expiration_date' => 'nullable|date',
            'status' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
            'barcode' => 'nullable|unique:products,barcode',
            'barcode_image' => 'nullable|image|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle barcode image upload
        if ($request->hasFile('barcode_image')) {
            $validatedData['barcode_image'] = $request->file('barcode_image')->store('barcodes', 'public');
        }

        // Generate barcode if not provided
        if (!isset($validatedData['barcode'])) {
            $validatedData['barcode'] = $this->generateUniqueBarcode();
        }

        $product = Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'expiration_date' => 'nullable|date',
            'status' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
            'barcode' => 'nullable|unique:products,barcode,' . $product->id,
            'barcode_image' => 'nullable|image|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle barcode image upload
        if ($request->hasFile('barcode_image')) {
            // Delete old barcode image if exists
            if ($product->barcode_image) {
                Storage::disk('public')->delete($product->barcode_image);
            }
            $validatedData['barcode_image'] = $request->file('barcode_image')->store('barcodes', 'public');
        }

        // Generate barcode if not provided
        if (!isset($validatedData['barcode'])) {
            $validatedData['barcode'] = $this->generateUniqueBarcode();
        }

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        // Delete associated images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        if ($product->barcode_image) {
            Storage::disk('public')->delete($product->barcode_image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
    }

    public function generateBarcode(Request $request)
    {
        $type = $request->input('type', 'EAN13');
        $code = $request->input('code', $this->generateUniqueBarcode());

        try {
            $barcode = DNS1DFacade::getBarcodePNGPath($code, $type);
            return response()->json([
                'success' => true,
                'barcode' => $code,
                'barcode_path' => $barcode
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generando código de barras'
            ], 500);
        }
    }

    private function generateUniqueBarcode()
    {
        do {
            $barcode = str_pad(mt_rand(1, 9999999999999), 13, '0', STR_PAD_LEFT);
        } while (Product::where('barcode', $barcode)->exists());

        return $barcode;
    }

    public function export()
    {
        // Implementar exportación de productos a Excel/CSV
    }

    public function import(Request $request)
    {
        // Implementar importación de productos desde Excel/CSV
    }
}