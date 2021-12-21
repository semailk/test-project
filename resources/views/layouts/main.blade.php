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
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
    i {
        cursor: pointer;
    }

    header {
        margin-top: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        font-family: 'Roboto', sans-serif;
    }
    header a {
        text-decoration: none;
        color: darkviolet;
        font-size: 25px;
    }

    #logo {
        font-size: 25px;
        color: black;
    }

    #logo span {
        color: red;
        font-size: 35px;
    }
</style>
<body>
<header>
    <a id="logo" href="{{ route('home') }}">Rai<span>s</span>on</a>
    <a href="{{ route('home') }}">Главная страница</a>
    <a href="{{ route('clients.index') }}">Клиенты</a>
    <a href="{{ route('managers.index') }}">Менеджера</a>
    <a href="{{ route('clients.create') }}">Добавить клиента</a>
</header>
<hr>
@yield('content')
</body>
</html>
