<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/logoicon.ico') }}" />

    <title>Cashier App</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">


    <!--ajax search here-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!--cdn for dark theme-->

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand navbar-light bg-light sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('img/logoicon.ico') }}" alt="" width="33" height="33"
                        class="d-inline-block align-top mr-5"> CashierApp</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Tsoggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        @guest
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/cashier">Cashier</a>
                            </li>
                        @endguest
                    </ul>
                    @guest
                        <span class="">
                            <a class="btn btn-outline-success" href="/login">Login</a>
                        </span>
                    @else
                        <span class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="text-dark"> {{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                                                                                                                                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </span>

                    @endguest
                </div>
            </div>
        </nav>


        <main class="container py-4">
            @yield('content')
        </main>
        <br><br><br><br><br><br><br><br>

        <footer class="bg-light text-center text-lg-start mt-5">
            <div class="container p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h3 class="text-uppercase">I'd love to hear from you</h3>
                        <div class="mt-5">
                            <a href="https://www.instagram.com/george_clm/" class="card-link" target="_blank"><img
                                    src="{{ asset('img/instagram.png') }}" style="width: 1.5rem; height: 1.5rem;"></a>
                            <a href="https://www.linkedin.com/in/epafroditus-george-5b66bb1b7/" class="card-link"
                                target="_blank"><img src="{{ asset('img/linkedin.png') }}"
                                    style="width: 1.5rem; height: 1.5rem;"></a>
                            <a href="https://github.com/georgeclm" class="card-link" target="_blank"><img
                                    src="{{ asset('img/github.png') }}" style="width: 1.5rem; height: 1.5rem;"></a>
                            <a href="https://api.whatsapp.com/send/?phone=6289647590083&text&app_absent=0"
                                class="card-link" target="_blank"><img src="{{ asset('img/whatsapp.png') }}"
                                    style="width: 1.5rem; height: 1.5rem;"></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">cavidjaja@gmail.com</h5>
                        <h5 class="text-uppercase mb-4">089647590083</h5>
                        <a class="btn btn-outline-dark btn-lg"
                            href="https://doc-0s-80-docs.googleusercontent.com/docs/securesc/0afulek9pr47gebntkhni3ms50h67n2n/epnian97836aujsgr7lbueg2e3utvod3/1611895950000/02063670884804000626/02063670884804000626/1BcKbeBN2NzoaNtAGuQS1UjZn31LYtVr5?e=download&authuser=0&nonce=9aq8jm713dgl0&user=02063670884804000626&hash=4t23gdd87a4rfd6gk1hg8a5ds77hokq8"
                            target="_blank">Download CV</a>
                    </div>
                </div>
            </div>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                © 2021 By Epafroditus George
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
</body>
<script type="text/javascript">
    $('.livesearch').select2({
        placeholder: 'Select Product Name or UPC Number',
        ajax: {
            url: '/search',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

</script>
<style>
    .link-web a {
        color: #000;
        text-decoration: none;
        transition: color 0.5s;
    }

    .link-web a:hover {
        transition: 1s;
        border-bottom: 0px;
        color: #646786;

    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

</style>

</html>
