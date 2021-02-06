<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();
        return view('product', ['products' => $data]);
    }
    public function create()
    {
        return view('addproduct');
    }
    public function store(Request $request)
    {
        $request->validate([
            'productname' => 'required',
            'category' => 'required',
            'price' => 'required',
            'stocks' => 'required',
            'upc' => ['required', 'unique:products'],
        ]);
        if ($request->hasFile('gallery')) {
            $request->validate([
                'gallery' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
            ]);
        }
        $request->file('gallery')->store('product', 'public');
        $product = new Product([
            "name" => $request->get('productname'),
            "price" => $request->get('price'),
            "category" => $request->get('category'),
            "stocks" => $request->get('stocks'),
            "upc" => $request->get('upc'),
            "gallery" => $request->file('gallery')->hashName(),
        ]);
        $product->save(); // Finally, save the record.
        return redirect('/');
    }
}
