<!DOCTYPE html>
<html lang="en">
<head>
    @section('head')
        <title>@yield('title') - Timers Project</title>
        <link rel="stylesheet" href="{{ asset('bootstrap-3.3.6-dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap-3.3.6-dist/css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/timer.css') }}">

        <script src="{{ asset('js/jquery-1.11.2.min.js') }}"></script>
        <script src="{{ asset('bootstrap-3.3.6-dist/js/bootstrap.min.js') }}"></script>

    @show
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Adventure Project</a>
        </div>
        <div id="navbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>{{ link_to_route('sign_in_page', 'Войти', ['class' => 'navbar-link']) }}</li>
                <li>{{ link_to_route('sign_up_page', 'Зарегиться', ['class' => 'navbar-link']) }}</li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-lg-3 col-sm-3 sidebar-offcanvas" id="sidebar">
            <div class="list-group">
                <a href="#" class="list-group-item active">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
                <a href="#" class="list-group-item">Link</a>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="row row-offcanvas row-offcanvas-right">
                <div class="col-lg-12">
                    <p class="alert {{ Session::get('alert-class', 'alert-warn') }}">{{ Session::pull('message') }}</p>
                </div>
            </div>

            @yield('content')
        </div>

    </div>
</div>
</body>
</html>




