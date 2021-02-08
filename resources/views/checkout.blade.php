<?php
$tax = $total * 0.1; ?>
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-sm-10">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td>Amount</td>
                        <td>Rp. {{ number_format($total) }}</td>
                    </tr>
                    <tr>
                        <td>Tax (10%)</td>
                        <td>Rp. {{ number_format($tax) }}</td>
                    </tr>
                    <tr>
                        <td>Total amount</td>
                        <td>Rp. {{ number_format($total + $tax) }}</td>
                    </tr>
                </tbody>
            </table>
            <div>
                <form action="/checkoutplace" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="pwd">Payment Method:</label> <br><br>
                        <input type="radio" value="cash" name="payment" id=""><span> Cash</span> <br><br>
                        <input type="radio" value="cash" name="payment" id=""><span> Credit Card</span><br><br>
                        <input type="radio" value="cash" name="payment" id=""><span> Debit</span> <br><br>
                    </div>
                    <input type="hidden" name="total" value="{{ $total + $tax }}">
                    <button type="submit" class="btn btn-outline-success">Pay</button>
                </form>
            </div>
        </div>
    </div>

@endsection
