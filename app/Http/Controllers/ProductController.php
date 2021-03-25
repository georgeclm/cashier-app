<?php

namespace App\Http\Controllers;


use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use App\Models\Product;
use App\Models\Buy;
use App\Models\Finish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class item
{
    private $name;
    private $price;

    public function __construct($name = '', $price = '')
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 38;

        $left = str_pad($this->name, $leftCols);

        $right = str_pad($this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $product = $products[0];
        return view('product', compact('products', 'product'));
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
            "value" => $request->get('price') * $request->get('stocks')
        ]);
        $product->save(); // Finally, save the record.
        return redirect('/')->with('success', 'Success Product Have Been Added');
    }
    public function cashier()
    {

        $userId = auth()->id();
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
        return view('cashier', compact('products'));
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

        // to take the product price as an array of price
        $product = Product::where('id', $request->livesearch)->get();
        if ($product[0]->stocks < $request->quantity) {
            return redirect('/cashier')->with('error', 'Quantity exceed product stocks');
        }
        $buy = new Buy;
        // take the user id from the session
        $buy->user_id = Auth::user()->id;
        // from livesearch this take the product id as selected
        $buy->product_id = $request->livesearch;
        // quantity from post request
        $buy->quantity = $request->quantity;
        // count the price by price x quantity
        $buy->price = $request->quantity * $product[0]->price;
        // save to the database buys
        $buy->save();
        return redirect('/cashier')->with('success', 'Product Added');
    }
    public function removeBuy($id)
    {
        Buy::destroy($id);
        return redirect('/cashier')->with('error', 'Product have been removed');
    }
    public function checkout(Request $request)
    {
        $total = $request->total_price;
        return view('checkout', compact('total'));
    }
    public function checkoutPlace(Request $request)
    {

        $userId = auth()->id();
        $allBuy = Buy::where('user_id', $userId)->get();
        $totalQuantity = Buy::where('user_id', $userId)->sum('quantity');
        $items = array();
        $loop = 0;
        foreach ($allBuy as $buy) {
            $thestock = Product::where('id', $buy['product_id'])->get();
            $data = [
                'stocks' => $thestock[0]->stocks - $buy['quantity'],
                "value" => $thestock[0]->price * ($thestock[0]->stocks - $buy['quantity'])
            ];
            Product::where('id', $buy['product_id'])->update($data);
            $products = Product::where('id', $buy['product_id'])->get();
            $productName = $products[0]->name;
            $productPrice = $buy['quantity'] * $products[0]->price;
            $items[$loop] = new item($productName, $productPrice);
            // dd($prices[$loop]);
            $loop++;
        };
        Buy::where('user_id', $userId)->delete();
        $connector = new FilePrintConnector("php://stdout");
        $printer = new Printer($connector);
        $printer->text("Hello World!\n");
        $printer->cut();
        $printer->close();
        $finish = new Finish;
        $finish->user_id = $userId;
        $finish->payment_method = $request->payment;
        $finish->total = $request->total;
        $finish->quantity = $totalQuantity;
        $finish->save();
        return redirect('/cashier')->with('success', 'Buy Have Been Placed');
    }
}
