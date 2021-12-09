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
        $product = new Product();
        $totalProfit = $product->totalProfit();
        $finishes = Finish::latest()->get();
        return view('history', compact('finishes', 'totalProfit'));
    }
}
