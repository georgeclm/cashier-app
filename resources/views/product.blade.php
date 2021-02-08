{{-- This is the Product Home View to show all the product and for the function
    to pass the total value from the function inside the controller and take
    the total value to displayfor the template from app and content to add product
    and the other --}}
<?php
$value = 0;
$userSales = 0;
$participation = 0;
$target = 0;
use App\Http\Controllers\FinishController;
$totalSales = FinishController::totalProfit();
if (Auth::user()) {
$userSales = FinishController::userProfit();
$target = FinishController::targetContribution();
if ($userSales != 0) {
$participation = ($userSales / $totalSales) * 100;
}
}
?>
@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="col-md-12">
            <h3 class='mb-4'>Products</h3>
            <a href="/product/create" class="btn btn-outline-success mb-3">Add Product</a>
            <div class="row">
                <div class="col-md-8">
                    <div class="row row-cols-1 row-cols-md-4">
                        @foreach ($products as $item)
                            <div class="col mb-4 link-web">
                                {{-- <a href="detail/{{ $item['id'] }}"> --}}
                                <div class="card h-100 rounded" style="width: 12rem;">
                                    <img src="{{ asset("storage/product/{$item['gallery']}") }}" class="card-img-top"
                                        style="width: 12rem; height: 12rem; background-size: cover; background-position: center;">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $item['name'] }}</h6>
                                        <h5 class="card-text"> Rp. {{ number_format($item['price']) }}</h5>
                                        <h6 class="card-text">Stock: {{ $item['stocks'] }}</h6>
                                    </div>
                                </div>
                                {{-- </a> --}}
                            </div>
                            <input type="hidden" name="" value="{{ $value += $item['price'] * $item['stocks'] }}">
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Total Product Value</td>
                                <td>Rp. {{ number_format($value) }}</td>
                            </tr>
                            <tr>
                                <td>Total Sales</td>
                                <td>Rp. {{ number_format($totalSales) }}</td>
                            </tr>
                            @guest
                            @else
                                <tr>
                                    <td>Your Sales</td>
                                    <td>Rp. {{ number_format($userSales) }}</td>
                                </tr>
                                <tr>
                                    <td>Your Target Contribution</td>
                                    <td>{{ number_format($target, 2) }} %</td>
                                </tr>

                                <tr>
                                    <td>Your Contribution</td>
                                    <td>{{ number_format($participation, 2) }} %</td>
                                </tr>
                            @endguest

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection
