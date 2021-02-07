<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Buy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            "value" => $request->get('price') * $request->get('stocks')
        ]);
        $product->save(); // Finally, save the record.
        return redirect('/');
    }
    static function productValue()
    {
        $total = DB::table('products')
            ->sum('value');
        return $total;
    }
    public function cashier()
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            return view('cashier');
        }
    }
    public function search(Request $request)
    {
        $name = [];
        if ($request->has('q')) {
            $search = $request->q;
            $name = Product::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($name);
    }
    public function addToBuy(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            // everytime the user hit addtobuy then create new class buy
            $cart = new Buy;
            // take the user id from the session
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $request->livesearch;
            // save to the database buys
            $cart->save();
            return redirect('/');
        }
    }
}
