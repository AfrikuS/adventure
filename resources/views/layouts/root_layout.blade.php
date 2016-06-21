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
                <li class="active">{{ link_to_route('index_page', 'Home', []) }}</li>
                <li>{{ link_to_route('auction_page', 'Auction', []) }}</li>
                <li>{{ link_to_route('search_enemy_action', 'Search opp', []) }}</li>
                <li>{{ link_to_route('battle_page', 'В атаку!', []) }}</li>
                <li>{{ link_to_route('macro_page', 'Macro', []) }}</li>
                <li>{{ link_to_route('profile_page', 'Profile', []) }}</li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ Auth::user()->id }}" class="navbar-link">{{ Auth::user()->name }} ({{ Auth::user()->id }})</a></li>
                <li>{{ link_to_route('logout_action', 'Выйти', ['class' => 'navbar-link']) }}</li>
            </ul>
        </div>
    </div>
</nav>

@section('content')
@show

@section('timer')
    <script src="{{ asset('js/jquery.simple.timer.js') }}"></script>
    <script>

        var options = {
            onComplete: function() {
                window.location.reload();
            }
        };
        $(function(){
            $('.timer').startTimer(options);
        });
    </script>
@show

@yield('scripts')

</body>
</html>

