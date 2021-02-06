@extends('layouts.app')

@section('content')
    <div class="container mb-5 mt-5">
        <div class="col-md-12">
            <h3 class='mb-4'>Products</h3>
            <a href="/product/create" class="btn btn-outline-success mb-3">Add Product</a>

            <div class="row row-cols-1 row-cols-md-6">
                @foreach ($products as $item)
                    <div class="col mb-4 link-web">
                        <a href="detail/{{ $item['id'] }}">
                            <div class="card h-100 rounded" style="width: 12rem;">
                                <img src="{{ asset("storage/product/{$item['gallery']}") }}" class="card-img-top" style="width: 12rem;
                                                                            height: 12rem;
                                                                            background-size: cover;
                                                                            background-position: center;">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $item['name'] }}</h6>
                                    <h5 class="card-text"> Rp. {{ $item['price'] }}</h5>
                                    <h6 class="card-text">Stock: {{ $item['stocks'] }}</h6>


                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

@endsection
