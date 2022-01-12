<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');

    i {
        cursor: pointer;
    }

    ul li {
        margin-top: 20px;
        display: inline;
        /*flex-direction: column;*/
        /*justify-content: space-around;*/
        font-family: 'Roboto', sans-serif;
    }

    ul a {
        text-decoration: none;
        color: darkviolet;
        font-size: 13px;
    }

    #logo {
        font-size: 25px;
        color: black;
    }

    .container {
        display: flex;
    }

    #logo span {
        color: red;
        font-size: 35px;
    }
</style>
<body>


<div class="content d-flex">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <a id="logo" href="{{ route('home') }}">Rai<span>s</span>on</a>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link active" aria-current="page">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#home"></use>
                    </svg>
                    Главная страница
                </a>
            </li>
            <li>
                <a href="{{ route('clients.index') }}" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#speedometer2"></use>
                    </svg>
                    Клиенты
                </a>
            </li>
            <li>
                <a href="{{ route('managers.index') }}" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#table"></use>
                    </svg>
                    Менеджера
                </a>
            </li>
            <li>
                <a href="{{ route('managers.plain') }}" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#table"></use>
                    </svg>
                    Задать менеджеру план
                </a>
            </li>
            <li>
                <a href="{{ route('clients.create') }}" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#grid"></use>
                    </svg>
                    Добавить клиента
                </a>
            </li>
            @if(auth()->check())
                <li style="font-size: 15px;color: white">Привет, {{ auth()->user()->name }}!</li>
                <li><a href="{{ route('exit') }}">Выйти</a></li>
            @else
                <li>
                    <a href="{{ route('login') }}">Авторизоваться</a>
                    <a href="{{ route('register') }}">Регистрация</a>
                </li>
            @endif
        </ul>
        <hr>
    </div>

    @yield('content')</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('.nav-pills li a').click(function () {
            $('.nav-pills li a').attr('class', 'nav-link text-white');
            $(this).attr('class', 'nav-link active');
        });
    });
</script>
