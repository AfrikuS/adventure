@extends('layouts.root_layout')

@section('content')
    <div class="container">
        @if(Session::has('message'))
            <div class="row row-offcanvas row-offcanvas-right">
                <div class="col-lg-12">
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::pull('message') }}</p>
                    @if(Session::has('errors'))
                        @foreach(Session::pull('errors') as $message)
                            <p class="alert {{ Session::get('alert-class', 'alert-warning') }}">{{ $message }}</p>
                        @endforeach
                        {{--{{ inset() }}--}}
                    @endif
                </div>
            </div>
        @endif
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-2">
                <dl>
                    <dt>Служебные</dt>
                    <dd>{{ link_to_route('maxovik_page', 'Maxovik', []) }}</dd>
                    <dd>{{ link_to_route('admin_page', 'Админка (сделать что-то)', []) }}</dd>
                    <dd>{{ link_to_route('auction_page', 'Аукцион', []) }}</dd>
                    <dd>{{ link_to_route('sea_travels_page', 'В порт', []) }}</dd>
                    <dt>Дела внешней торговли</dt>
                    <dd><a href="/boss">Босс</a></dd>
                    <dd><a href="/npc/offers">Актуальные предложения</a></dd>
                    <dd>{{ link_to_route('battle_page', 'В атаку!', []) }}</dd>
                    <dd></dd>
                    <dt>Служебные</dt>
                    <dd>{{ link_to_route('work_index_page', 'Работа!', []) }}</dd>
                </dl>

                @yield('left_column')
            </div>

            <div class="col-lg-7">
                {!! Breadcrumbs::renderIfExists() !!}

                @yield('center')
            </div>

            <div class="col-lg-3 col-sm-3">
                    <p>
                    Hero-ресурсы
                    <ul>
                        <li>Нефть: {{ $heroResources->oil }}</li>
                        <li>Золото: {{ $heroResources->gold}}</li>
                        <li>Вода: {{ $heroResources->water }}</li>
                    </ul>
                    <p>
                    <p>
                    Макро-ресурсы
                    <ul>
                        <li>Еда: {{ $resources->food }}</li>
                        <li>Дерево: {{ $resources->tree}}</li>
                        <li>Вода: {{ $resources->water }}</li>
                        <li>Свободные жители: {{ $resources->free_people }}</li>
                    </ul>
                    <p>
                    @yield('right_column')
            </div>
        </div>
    </div>

@endsection

