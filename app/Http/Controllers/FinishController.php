<?php

namespace App\Http\Controllers;



use App\Models\Finish;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinishController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $product = $products[0];
        $finishes = DB::table('finishes')
            ->orderByDesc('created_at')
            ->get();
        return view('history', compact('finishes', 'product'));
    }
}
