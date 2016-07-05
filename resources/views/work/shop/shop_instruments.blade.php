@extends('layouts.app')

@section('title', 'Sea -> Travel Port')
@section('head')
    @parent
@endsection

@section('center')

    Магазин инструментов для строительства
    <p>
    {{ link_to_route('work_shop_page', 'Материалы') }}
    <p></p>
    <div class="row row-offcanvas">
        <div class="col-lg-7">
            @if(count($shopInstruments) > 0)
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
                        @foreach($shopInstruments as $shopInstrument)
                            <tr>
                                <td>{{ $shopInstrument->code }}</td>
                                <td>{{ $shopInstrument->price }}</td>
                                <td>
                                    {!! Form::open(['route' => 'work_shop_buy_instrument_action', 'class' => '']) !!}
                                    {!! Form::hidden('instrument', $shopInstrument->code) !!}
                                    {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>Купить (1 шт.)</td>
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

            Ваши инcтрументы:

            @if ($userInstruments != null)
                <ul>
                    <li>Инструмент \ Заряды </li>
                    @foreach($userInstruments as $instrument)
                        <li>{{ $instrument->code . " - "  .$instrument->skill_level }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>


@endsection

