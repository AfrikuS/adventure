@extends('layouts.root_layout')

@section('content')
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="row row-offcanvas row-offcanvas-right">
                <div class="col-lg-12">
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::pull('message') }}</p>
                    @if(Session::has('errors'))
                        @foreach(Session::pull('errors') as $message)
                            <p class="alert {{ Session::get('alert-class', 'alert-warning') }}">{{ $message }}</p>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-2">

                @include('_partials.npc.offers')
                <p></p>
                @include('_partials.npc.deals')

                @yield('left_column')
            </div>

            <div class="col-lg-7">
                {!! Breadcrumbs::renderIfExists() !!}

                @yield('center')
            </div>

            <div class="col-lg-3">
                    <p>
                    Hero-ресурсы
                    <ul>
                        <li>Нефть: {{ $hero->oil }}</li>
                        <li>Золото: {{ $hero->gold}}</li>
                        <li>Вода: {{ $hero->water }}</li>
                    </ul>
                    <p>
                    <p>

                    @include('_partials.npc.offer_generate')

                    <p>
                    <p>
                    <p>
                    {{--{!! Form::open(['route' => 'npc_generate_offer_page', 'class' => '']) !!}--}}
                    {{--{!! Form::submit('Normalize user', array('class' => 'btn btn-warning')) !!}--}}
                    {{--{!! Form::close() !!}--}}
                    <p>
                @yield('right_column')
            </div>
        </div>
    </div>

@endsection

