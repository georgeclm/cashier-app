{{-- This is the Product Home View to show all the product and for the function
    to pass the total value from the function inside the controller and take
    the total value to displayfor the template from app and content to add product
    and the other --}}
<?php
use App\Http\Controllers\FinishController;
$balance = 0;
?>
@extends('layouts.app')

@section('content')

    <div class="container mb-5">
        <div class="col-md-12">
            <h3 class='mb-4'>Products</h3>
            <a href="/product/create" class="btn btn-outline-secondary mb-3">Add Product</a>
            <div class="row">
                <div class="col-md-8">
                    <div class="row row-cols-1 row-cols-md-4">
                        @foreach ($products as $item)
                            <div class="col mb-4 link-web">
                                {{-- <a href="detail/{{ $item['id'] }}"> --}}
                                <div class="card h-100 rounded" style="width: 12rem;">
                                    <img src="{{ asset("storage/product/{$item->gallery}") }}" class="card-img-top"
                                        style="width: 12rem; height: 12rem; background-size: cover; background-position: center;">
                                    <div class="card-body">

                                        <h6 class="card-title">{{ $item->name }}</h6>
                                        <h5 class="card-text"> Rp. {{ number_format($item->price, 0, ',', '.') }}
                                        </h5>
                                        <h6 class="card-text">Stock: {{ $item->stocks }}</h6>
                                    </div>
                                </div>
                                {{-- </a> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Gross Merchandise Value (GMV)</td>
                                <td>Rp. {{ number_format($product->value(), 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Total Sales</td>
                                <td>Rp. {{ number_format($product->totalProfit(), 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Today Sales</td>
                                <td>Rp. {{ number_format($product->todaySales(), 0, ',', '.') }}</td>
                            </tr>
                            <input type="hidden" value="{{ $balance = $product->totalProfit() - $product->value() }}">
                            <tr>
                                <td>Balance Sheet</td>
                                <td>Rp. {{ number_format($balance, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Total Product Sold</td>
                                <td>{{ $product->totalQuantity() }}</td>
                            </tr>
                            <tr>
                                <td>Average Basket Size</td>
                                <td>{{ number_format($product->averageQuantity(), 2, ',', '.') }}</td>
                            </tr>

                        </tbody>
                    </table>
                    @guest
                    @else
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>Your Sales</td>
                                    <td>Rp. {{ number_format($product->userProfit(), 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Your Target Contribution</td>
                                    <td>{{ number_format($product->targetContribution(), 2, ',', '.') }} %</td>
                                </tr>

                                <tr>
                                    <td>Your Contribution</td>
                                    <td>{{ number_format($product->participation(), 2, ',', '.') }} %</td>
                                </tr>

                            </tbody>
                        </table>
                    @endguest



                </div>
            </div>

        </div>
    </div>
@endsection
