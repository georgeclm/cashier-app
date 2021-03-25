<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'category',
        'stocks',
        'upc',
        'gallery',
        'value',
    ];
    protected $guarded = [];
    static function averageQuantity()
    {
        $avgQuantity = Finish::average('quantity');
        return $avgQuantity;
    }
    static function totalQuantity()
    {
        $totalQuantity = Finish::sum('quantity');
        return $totalQuantity;
    }
    static function totalProfit()
    {
        $profit = Finish::sum('total');
        return $profit;
    }

    static function todaySales()
    {
        $allCreated = Finish::get();
        $today = $allCreated->map(function ($item, $key) {
            if ($item->created_at->format('Y-m-d') == now()->format('Y-m-d')) {
                return $item;
            }
        });
        $sales = $today->sum('total');
        return $sales;
    }

    static function userProfit()
    {
        $profit1 = Finish::where('user_id', auth()->id())
            ->sum('total');
        return $profit1;
    }
    static function targetContribution()
    {
        $target = 100 / User::count();
        return $target;
    }
    static function participation()
    {
        if (Product::userProfit() != 0) {
            return (Product::userProfit() / Product::totalProfit()) * 100;
        }
        return 0;
    }
    static function value()
    {
        return Product::sum('value');
    }
}
