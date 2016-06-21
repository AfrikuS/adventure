@extends('layouts.not_auth')

@section('title', '404 error - Page')
@section('head')
    @parent
@endsection

@section('content')

    <div class="container">
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
            </div>
        </div>
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-9 col-sm-9">

                Страница не найдена. 404
            </div>

            <div class="col-lg-3 col-sm-3">
            </div>

        </div>
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-4 col-sm-4">



            </div>

            <div class="col-lg-8 col-sm-8">
            </div>
        </div>

    </div>
@endsection
