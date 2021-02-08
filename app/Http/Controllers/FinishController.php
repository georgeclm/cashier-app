<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinishController extends Controller
{
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
