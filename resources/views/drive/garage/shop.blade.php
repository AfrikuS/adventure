@extends('drive.garage.garage_layout')

@section('title', 'Drive -  Garage Shop')

@section('center')

    Купить авто-детали, горючку, инструменты, к-ые появятся\улучшатся в гараже
    <p>

    <div class="row row-offcanvas">
        <div class="col-lg-7">

            @if($detailsOffers->count() > 0)
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
                        @foreach($detailsOffers as $offer)
                            <tr>
                                <td>{{ $offer->id }}</td>
                                <td>{{ $offer->kind->title }}</td>
                                <td>{{ $offer->title }}</td>
                                <td>
                                    {!! Form::open(['route' => 'drive_shop_buy_detail_action', 'class' => '']) !!}
                                    {!! Form::hidden('offer_id', $offer->id) !!}
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
        <div class="col-lg-3">
            <ul>
                <li>Колеса - </li>
                <li>Подвеска (связь между корпусом и колесами, в т.ч. у рельсовых), степнь жесткости от ж - к мяг</li>
                <li>Кузов- body</li>
                <li>Трансмиссия (совок-ть механизмов и деталей, в т.ч. сцепление, коробка, дифф-ал). соед-ет двигатель и ведущие колеса</li>
                <li>Двигатель</li>
                <li>Топливная система (бак, топливоприводы - трубки\шланги, насос)</li>
            </ul>

            Подвески:
            Жёсткие
            Полужёсткие (тракторные)
            Мягкие (эластичные и упругие)

            независимая\зависимая

            активная (управляемая) \ пассивная (не)

        </div>
    </div>


@endsection

@section('right_column')

    @parent

    {!! Form::open(['route' => 'drive_shop_reindex_prices_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Обновить ассортимент', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}

@endsection
