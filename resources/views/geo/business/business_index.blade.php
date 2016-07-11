@extends('layouts.app')

@section('title', 'Geo - Business')
@section('head')
    @parent
@endsection

@section('center')

        <div class="row row-offcanvas">
            <div class="col-lg-6">
                <p></p>
            </div>

            <div class="col-lg-6">
            </div>
        </div>

        <div class="row row-offcanvas">
            <div class="col-lg-4">
                <ul>
                    <li>{{ link_to_route('geo_sea_freights_page', 'Морские грузоперевозки') }}</li>
                    <li>{{ link_to_route('geo_trader_temposhops_page', 'Торговые палатки в порту') }}</li>
                </ul>
            </div>

            <div class="col-lg-8">
            </div>
        </div>

@endsection

