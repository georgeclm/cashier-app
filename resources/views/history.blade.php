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
                @if ($finishes->count())
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
                                    <td>{{ $item->created_at->format('l j M, g:i a') }}</td>
                                    <td>{{ $item->payment_method }}</td>
                                    <td>{{ $item->quantity }}</td>

                                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Rp. {{ number_format($totalProfit, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <div class="d-grid gap-2 col-5 mx-auto text-center">
                        <br><br>
                        <h2 class="mb-3 fs-1">History is empty </h2>
                        <a class="btn btn-outline-secondary btn-lg" href="{{ route('cashier') }}"> Go to Cashier</a>
                    </div>

                @endif

            </div>
        </div>
    </div>

@endsection
