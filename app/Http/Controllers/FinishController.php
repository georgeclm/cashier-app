<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinishController extends Controller
{
    public function index()
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            $userId = Auth::user()->id;
            $finishes = DB::table('finishes')
                //->join('products', 'finishes.product_id', '=', 'products.id')
                ->orderByDesc('created_at')
                ->get();
            return view('history', ['finishes' => $finishes]);
        }
    }
    static function hasFinish()
    {
        $userId = Auth::user()->id;
        $data = Finish::where('user_id', $userId)->count();
        if ($data == 0) {
            return 'yes';
        } else {
            return 'no';
        }
    }
    static function totalProfit()
    {
        $profit = Finish::sum('total');
        return $profit;
    }
    static function userProfit()
    {
        $profit1 = Finish::where('user_id', Auth::user()->id)
            ->sum('total');
        return $profit1;
    }
    static function targetContribution()
    {
        $target = 100 / User::count();
        return $target;
    }
    static function totalQuantity()
    {
        $totalQuantity = Finish::sum('quantity');
        return $totalQuantity;
    }
    static function averageQuantity()
    {
        $avgQuantity = Finish::average('quantity');
        return $avgQuantity;
    }
    static function todaySales()
    {
        $allCreated = Finish::get();
        //dd($sales);
        //dd($data[0]->created_at->format('Y-m-d'));
        foreach ($allCreated as $date) {
            $thedate = $date->created_at->format('Y-m-d');
            $data = [
                'created_at' => $thedate,
            ];
            Finish::where('id', $date['id'])->update($data);
        }
        $sales = Finish::where("created_at", now()->format('Y-m-d'))
            ->sum('total');
        return $sales;
    }
}
