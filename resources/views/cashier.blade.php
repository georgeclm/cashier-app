<?php
$total = 0; ?>
@extends('layouts.app')
@section('content')
    <div class="container mt-3">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <form action="/add_to_buy" method="POST" class='form-control'>
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <select class="livesearch form-control" name="livesearch" required></select>
                        </div>
                        <div class="col-md-1">
                            <label for="exampleInputEmail1" class="form-label">Quantity: </label>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                placeholder="0" name="quantity" required>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-outline-success" type="submit">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>Rp. {{ number_format($item->price) }}</td>
                            <td>{{ $item->buys_quantity }}</td>
                            <td>Rp. {{ number_format($item->buys_price) }}</td>
                            <input type="hidden" name="total_price" value="{{ $total += $item->buys_price }}">
                            <td><a href="/removebuy/{{ $item->buys_id }}" class="btn btn-outline-danger">Remove</a></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Rp. {{ number_format($total) }} </td>
                </tbody>
            </table>
            <div class="row">
                <form action="checkout" method="POST">
                    @csrf
                    <input type="hidden" name="total_price" value="{{ $total }}">
                    <button class="btn btn-outline-dark" type="submit">Checkout</button>
                </form>

            </div>

        </div>
    </div>
@endsection
