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
                <li class="active">{{ link_to_route('profile_page', 'Profile', []) }}</li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Battle<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('search_page', 'Search opp') }}</li>
                        <li>{{ link_to_route('bodalka_page', 'Bodalka') }}</li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Massive</li>
                        <li>{{ link_to_route('boss_page', 'Boss') }}</li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Trade<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('auction_page', 'Аукцион') }}</li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Macro<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('macro_page', 'Центральная площадь') }}</li>
                        <li>{{ link_to_route('macro_obtain_page', 'Добыча ресурсов') }}</li>
                        <li>{{ link_to_route('macro_buildings_page', 'Строительство') }}</li>
                        <li>{{ link_to_route('macro_exchange_page', 'Точка обмена') }}</li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Work \ Orders<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('work_index_page', 'Work Index') }}</li>
                        <li>{{ link_to_route('work_orders_page', 'Single Orders') }}</li>
                        <li>{{ link_to_route('work_teamorders_page', 'Team Orders') }}</li>
                        <li>{{ link_to_route('work_show_privateteam_page', 'My Team', ['id' => 1]) }}</li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">{{ link_to_route('work_shop_page', 'Work Shop') }}</li>
                        <li>{{ link_to_route('work_privateteams_page', 'Teams List') }}</li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Geo<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('geo_index_page', 'Порт') }}</li>
                        <li>{{ link_to_route('geo_live_voyage_page', 'Live Travels (new)') }}</li>
                        <li>{{ link_to_route('geo_travels_page', 'Travels \ Orders') }}</li>
                    </ul>
                </li>
                <li class="active">{{ link_to_route('admin_page', 'Admin', []) }}</li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>{{ link_to_route('maxovik_page', 'Maxovik') }}</li>
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

    @yield('scripts')
    </script>
@show


</body>
</html>

