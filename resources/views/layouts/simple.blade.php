@extends('layouts.root_layout')

@section('content')
    <div class="container">
        @if(Session::has('message'))
            <div class="row row-offcanvas row-offcanvas-right">
                <div class="col-lg-12">
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                </div>
            </div>
        @endif
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-2 col-sm-2">
                @yield('left_column')
            </div>

            <div class="col-lg-7">
                @yield('center')
            </div>

            <div class="col-lg-3 col-sm-3">
                @yield('right_column')
            </div>
        </div>
    </div>

@endsection

