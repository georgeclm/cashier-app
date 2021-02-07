@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-center">
                <form action="/add_to_buy" method="POST">
                    @csrf
                    <select class="livesearch form-control" name="livesearch" required></select>
                    <br><br>
                    <button class="btn btn-outline-success" type="submit">Add</button>
                </form>
            </div>

        </div>
    </div>
@endsection
