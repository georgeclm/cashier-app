<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Buy;
use App\Models\Finish;
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
                'gallery' => 'mimes:jpeg,bmp,png,jpg' // Only allow .jpg, .bmp and .png file types.
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
            // "value" => $request->get('price') * $request->get('stocks')
        ]);
        $product->save(); // Finally, save the record.
        return redirect('/')->with('success', 'Success Product Have Been Added');
    }
    public function cashier()
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            $userId = Auth::user()->id;
            // this join data from other table to display first is the main table which is buys
            $products = DB::table('buys')
                // join this table with products table where the product id is same as product id in buys to take the necessary product only
                ->join('products', 'buys.product_id', '=', 'products.id')
                // make sure the user id is the same as user account
                ->where('buys.user_id', $userId)
                // take all products in the table, on buys table take buys id as the new name, quantity and the price of product
                ->select('products.*', 'buys.id as buys_id', 'buys.quantity as buys_quantity', 'buys.price as buys_price')
                // get function to take all into object and pass to the view
                ->get();
            return view('cashier', ['products' => $products]);
        }
    }
    public function search(Request $request)
    {
        $name = [];
        if ($request->has('q')) {
            $search = $request->q;
            $name = Product::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('upc', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($name);
    }
    public function addToBuy(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            // to take the product price as an array of price
            $productPrice = Product::where('id', $request->livesearch)->get("price");
            // always die dump data to make sure take the correct data
            //dd($request);
            //dd($productPrice[0]->price);
            // everytime the user hit addtobuy then create new object buy
            $buy = new Buy;
            // take the user id from the session
            $buy->user_id = Auth::user()->id;
            // from livesearch this take the product id as selected
            $buy->product_id = $request->livesearch;
            // quantity from post request
            $buy->quantity = $request->quantity;
            // count the price by price x quantity
            $buy->price = $request->quantity * $productPrice[0]->price;
            // save to the database buys
            $buy->save();
            return redirect('/cashier')->with('success', 'Product Added');
        }
    }
    public function removeBuy($id)
    {
        Buy::destroy($id);
        return redirect('/cashier')->with('error', 'Product have been removed');
    }
    public function checkout(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            $total = $request->total_price;
            return view('checkout', ['total' => $total]);
        }
    }
    public function checkoutPlace(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            $userId = Auth::user()->id;
            $allBuy = Buy::where('user_id', $userId)->get();
            $totalQuantity = Buy::where('user_id', $userId)->sum('quantity');
            foreach ($allBuy as $buy) {
                $thestock = Product::where('id', $buy['product_id'])->get();
                if ($thestock[0]->stocks > $buy['quantity']) {
                    $data = [
                        'stocks' => $thestock[0]->stocks - $buy['quantity'],
                    ];
                    Product::where('id', $buy['product_id'])->update($data);
                    Buy::where('user_id', $userId)->delete();
                } else {
                    return redirect('/cashier')->with('error', 'The Quantity Exceed Product Stocks');
                }
            };
            $finish = new Finish;
            $finish->user_id = $userId;
            $finish->payment_method = $request->payment;
            $finish->total = $request->total;
            $finish->quantity = $totalQuantity;
            $finish->save();
            return redirect('/cashier')->with('success', 'Buy Have Been Placed');
        }
    }
}
