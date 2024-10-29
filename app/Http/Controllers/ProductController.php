<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Mengambil semua produk dari database
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        // Menampilkan form untuk membuat produk baru
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric|between:0,999999.99', // Menggunakan numeric dan between untuk validasi harga
            'description' => 'nullable|string' // Menambahkan validasi string untuk deskripsi
        ]);

        // Membuat produk baru di database
        Product::create($data);

        // Redirect ke halaman index produk setelah berhasil menyimpan
        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        // Menampilkan form untuk mengedit produk yang dipilih
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validasi data yang diterima dari form
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric|between:0,999999.99', // Menggunakan numeric dan between untuk validasi harga
            'description' => 'nullable|string' // Menambahkan validasi string untuk deskripsi
        ]);

        // Memperbarui data produk yang dipilih
        $product->update($data);

        // Redirect ke halaman index produk setelah berhasil memperbarui
        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }
}
