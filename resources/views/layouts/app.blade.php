<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css" />
    
    @yield('css')

    <title>{{ config('app.name', 'rrppManager') }}</title>

    <!-- Scripts -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        .form-group2 {
            text-align: justify;
        }

        .navbar {
            background: #AB0A3D;
            /*#009DC7;*/
        }

        .card-title {
            background: #440412;
            /* #009DC7;*/
            text-align: center;
            color: white;
            font-size: 24px;
        }


        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        #modal_alerta {
            margin-top: 10%;
        }

        #modal_alerta .modal-header {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .nav-link {
            color: white !important;
        }

        .dt-button {
            padding: 0;
            border: none;
        }

        fieldset.borde-field {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.borde-field {
            width: inherit;
            /* Or auto */
            padding: 0 10px;
            /* To give a bit of padding on the left and right */
            border-bottom: none;
        }

        input[type="radio"] {
            position: absolute;
            left: -9999px
        }

        input[type="radio"]+label {
            position: relative;
            padding: 3px 0 0 40px;
            cursor: pointer
        }

        input[type="radio"]+label:before {
            content: '';
            background: #fff;
            border: 2px solid #bbb;
            height: 25px;
            width: 25px;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0
        }

        input[type="radio"]+label:after {
            content: '';
            background: #B68400;
            /* #009DC7;*/
            width: 15px;
            height: 15px;
            border-radius: 50%;
            position: absolute;
            top: 5px;
            left: 5px;
            opacity: 0;
            transform: scale(2);
            transition: transform 0.3s linear, opacity 0.3s linear
        }

        input[type="radio"]:checked+label:after {
            opacity: 1;
            transform: scale(1)
        }



        input[type="checkbox"] {
            position: absolute;
            left: -9999px
        }

        input[type="checkbox"]+label {
            position: relative;
            padding: 3px 0 0 40px;
            cursor: pointer;
            color: rgb(120, 119, 121)
        }

        input[type="checkbox"]+label:before {
            content: '';
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 3px;
            height: 25px;
            width: 25px;
            position: absolute;
            top: 0;
            left: 0
        }

        input[type="checkbox"]+label:after {
            content: '';
            border-style: solid;
            border-width: 0 0 2px 2px;
            border-color: transparent transparent #311B92 #311B92;
            width: 15px;
            height: 8px;
            position: absolute;
            top: 6px;
            left: 5px;
            opacity: 0;
            transform: scale(2) rotate(-45deg);
            transition: transform 0.3s linear, opacity 0.3s linear
        }

        input[type="checkbox"]:checked+label:after {
            opacity: 1;
            transform: scale(1) rotate(-45deg);
            color: #311B92
        }

        label {
            display: flex;
            align-items: center
        }
    </style>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" style="color: white;" href="{{ url('/') }}">
                    Contactos
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">


                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Administración') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    @if (Auth::user()->permiso == 0)
                                        <h5 class="dropdown-header bg-secondary text-white">
                                            CATÁLOGOS
                                        </h5>
                                        <li>
                                            <a class="dropdown-item" href="/usuarios">{{ __('Usuarios') }}</a>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endif



                                    <li class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesion') }}
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>

                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fluid">

                @yield('content')

            </div>

        </main>
    </div>
    <!--sweetalert-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function mayusculas(e) {
            e.value = e.value.toUpperCase();
        }

        if ($(".HideAlert").length > 0) {
            setTimeout(function() {
                $(".HideAlert").remove();
            }, 5000);
        }

        // Swal.fire({
        //     title: 'Error!',
        //     text: 'Do you want to continue',
        //     icon: 'error',
        //     confirmButtonText: 'Cool'
        // })
    </script>



    @yield('js')

    @yield('script')



</body>

</html>
