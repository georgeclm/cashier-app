<?php

namespace App\Http\Controllers;

use App\Models\Finish;
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
        $profit = Finish::where('user_id', Auth::user()->id)
            ->sum('total');
        return $profit;
    }
}
