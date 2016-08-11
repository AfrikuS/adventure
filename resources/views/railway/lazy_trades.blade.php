@extends('railway._layout')

@section('title', 'Railway - Lazy Trades')
@section('head')
    @parent
@endsection

@section('center')

    Купить сегодня чтобы продать завтра
    <p>

    <div class="row row-offcanvas">
        <div class="col-lg-7">

            @if($prices->count() > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>kind</th>
                            <th>title</th>
                            <th>Покупка</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($prices as $price)
                            <tr>
                                <td>{{ $price->id }}</td>
                                <td>{{ $price->resource_code }}</td>
                                <td>{{ $price->railway_price }}</td>
                                <td>
                                    {!! Form::open(['route' => 'railway_trades_add_action', 'class' => '']) !!}
                                    {!! Form::hidden('code', $price->resource_code) !!}
                                    {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Деталей нет
            @endif
        </div>
        <div class="col-lg-5">
            Срок дейcтвия лицензии
            <p></p>
            <p></p>
            <div class="timer" data-seconds-left={{ $license->duration_seconds }}></div>

        </div>
    </div>


    <div class="row row-offcanvas">
        <div class="col-lg-7">

            @if($trades->count() > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>kind</th>
                            <th>title</th>
                            <th>title</th>
                            <th>Покупка</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trades as $trade)
                            <tr>
                                <td>{{ $trade->id }}</td>
                                <td>{{ $trade->resource_code }}</td>
                                <td>{{ $trade->resource_amount }}</td>
                                <td>{{ $trade->resource_price }}</td>
                                <td>
                                    {!! Form::open(['route' => 'railway_trades_take_action', 'class' => '']) !!}
                                    {!! Form::hidden('trade_id', $trade->id) !!}
                                    {!! Form::submit('Забрать', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Деталей нет
            @endif
        </div>
    </div>

@endsection

@section('right_column')

    @parent

    {!! Form::open(['route' => 'railway_reindex_prices_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Обновить цены', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}

@endsection
