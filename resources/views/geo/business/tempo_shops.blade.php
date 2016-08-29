@extends('geo.business._layout')

@section('title', 'Geo - Business')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <div class="col-lg-6">
            <p></p>
            Список торговых палаток с таймером окончания и ссылкой в магазин
            <p></p>Панель для распределения ресурсов \ управление ценами-скидками по палаткам
            <p></p>Склад товаров для палаток
        </div>

        <div class="col-lg-6">
            {{ link_to_route('geo_business_page', 'Back to kabinet') }}
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
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>shop ID</th>
                            <th>owner_name</th>
                            <th>ending_time</th>
                            <th>status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($shops as $shop)
                            <tr>
                                <td>{{ $shop->id }}</td>
                                <td>{{ $shop->owner_id }}</td>
                                <td><div class="timer" data-seconds-left={{ $shop->duration_seconds }}></div></td>
                                <td>{{ $shop->status }}</td>
                            </tr>
                        @empty
                            No TempoShops
                        @endforelse
                        </tbody>
                    </table>
                </table>

        </div>
    </div>

@endsection

@section('right_column')

    @parent

    {!! Form::open(['route' => 'geo_generate_temposhop_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Add tempo-shop', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection


