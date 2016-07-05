@extends('layouts.app')

@section('title', 'Sea -> Travel Port')
@section('head')
    @parent
@endsection

@section('center')

    Магазин материалов для строительства
    <p>
    {{ link_to_route('work_shop_instruments_page', 'Инструменты') }}
    <p></p>
    <div class="row row-offcanvas">
        <div class="col-lg-7">
            @if($shop->getProducts()->count() > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Material_CODE</th>
                            <th>price</th>
                            <th>Покупка</th>
                            <th>Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shop->getProducts() as $product)
                            <tr>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    {!! Form::open(['route' => 'work_shop_buy_material_action', 'class' => '']) !!}
                                    {!! Form::hidden('material', $product->code) !!}
                                    {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>Купить (10 ед.)</td>
                                {{--<td>{{ link_to_route('sea_delete_travel_action', 'Del', ['id' => $ship->id]) }}</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Товаров нет
            @endif
        </div>

        <div class="col-lg-5">

            Ваши материалы:

            @if ($userMaterials != null)
                <ul>
                    <li>Материал \ Количество</li>
                    @foreach($userMaterials as $material)
                        <li>{{ $material->code . " - "  .$material->value }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{--<div class="row row-offcanvas">--}}
        {{--<div class="col-lg-12">--}}
            {{--<ul>--}}
                {{--@foreach ($shop->getProducts() as $product)--}}
                    {{--<li>{{ $product->price }}</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}

        {{--</div>--}}
    {{--</div>--}}



@endsection

@section('right_column')

    @parent

    {!! Form::open(['route' => 'work_shop_reindex_prices_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Сменить цены на материалы', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection

