@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container custom-login">
        <div class="row justify-content-center">
            <div class="col-sm-4 col-sm-offset-4">
                <h4>Add Product</h4>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name of Product</label>
                        <input type="text" name="productname" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="mb-3 ">
                        <label class="form-label">Price of Product</label>
                        <input type="text" name="price" class="form-control" type-currency="IDR" inputmode="numeric"
                            required placeholder="Price">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control" placeholder="Category" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stocks of Product</label>
                        <input type="number" name="stocks" class="form-control" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UPC Number of Product</label>
                        <input type="number" name="upc" class="form-control" placeholder="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="gallery" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-outline-primary">Add Product</button>
                </form>

            </div>
        </div>
    </div>

@endsection
