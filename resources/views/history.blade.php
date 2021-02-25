<?php
use App\Http\Controllers\FinishController;
$value = FinishController::hasFinish();
$totalSales = FinishController::totalProfit();
?>
@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <h6>{{ $errors->first() }}</h6>
            </ul>
        </div>
    @endif

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <h6>{!! \Session::get('success') !!}</h6>
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="col-sm-10">
            <div class="trending-wrapper">
                @if ($value == 'no')
                    <h2 class="mb-3">History</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Payment Method</td>
                                <td>Quantity</td>
                                <td>Total</td>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finishes as $item)
                                <tr>
                                    <td>{{ substr($item->created_at, 0, 10) }}</td>
                                    <td>{{ $item->payment_method }}</td>
                                    <td>{{ $item->quantity }}</td>

                                    <td>Rp. {{ number_format($item->total) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>Rp. {{ number_format($totalSales) }}</td>

                            </tr>
                        </tbody>
                    </table>
                @else
                    <div class="d-grid gap-2 col-5 mx-auto text-center">
                        <br><br>
                        <h2 class="mb-3 fs-1">Order is empty </h2>
                        <a class="btn btn-outline-secondary btn-lg" href="/cartlist"> Go to Cart</a>
                    </div>

                @endif

            </div>
        </div>
    </div>

@endsection
