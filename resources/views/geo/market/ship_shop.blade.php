@extends('layouts.app')

@section('title', 'Travel Ship-Shop - Geo Travel Page')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        Dhtvя до закрытия лавки
        <h4>Выберите товары</h4>

        <div class="col-lg-7">
            <h4>Materials</h4>

            @if(count($pricesMaterials) > 0)
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
                        @foreach($pricesMaterials as $materialPrice)
                            <tr>
                                <td>{{ $materialPrice->code }}</td>
                                <td>{{ $materialPrice->price }}</td>
                                <td>
                                    {!! Form::open(['route' => 'travelship_buy_material_action', 'class' => '']) !!}
                                    {!! Form::hidden('shop_id', $shop->id) !!}
                                    {!! Form::hidden('material', $materialPrice->code) !!}
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
            Ваши материалы
            <p></p>
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

@endsection