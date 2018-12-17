<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">Cartes 113</a>
            <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="navigation" class="right hide-on-med-and-down">
                <li><a href="/">Accueil</a></li>
                <li><a href="{{ route('auctions') }}">Enchere</a></li>
                <li><a href="#">Livres</a></li>
            </ul>
        </div>
    </nav>
    <ul class="sidenav" id="mobile">
        <li><a href="/">Accueil</a></li>
        <li><a href="#">Enchere</a></li>
        <li><a href="#">Livres</a></li>
    </ul>
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>