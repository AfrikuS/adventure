@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('left_column')
    <dl>
        <dt>Profile LINKS</dt>
        <dd><a href="/work">Виды работ</a></dd>
        <dd><a href="/work/process">Работы по обработке ресурсов</a></dd>
    </dl>

@endsection

@section('center')

    Ваш кабинет по тиворкам и группам

    Работы по добыче шаров.
    <p>Шаро-добывающая шахта
    <dl>
        <dt>Белые шары (лопата, совок)</dt>
        <dt>Зеленые шары (лопата, совок) (дрель)</dt>
        <dt>Синие шары (лопата, совок) (агрегат, жидкость)</dt>
        <dt>Красные шары (лопата, совок) (тележка, белый шар)</dt>
        <dt>Фиолетовые шары (лопата, совок) (навык под добыче шаров > 38)</dt>
        <dt>Черные шары (лопата, совок) (добывается экспериментальным путем, вероятность добычи 33%, навык > 70%)</dt>
    </dl>
    <p>
    Вы можете создать свою закрытую private_teamwork без опытного лидера-наставника, заранее определившись с составом участников.
    Ограничение в том, что в такой группе вы будете работать всегда одним фиксированным составом, но будет возможность
        отправлять приглашения и добавлять 1-2 человек, к-ых затем можно будет ввести в осн. состав группы. У таких саомосты-х тимворков
    есть свои плюсы.
    <p>
    <dl>
        <dt>Single_work - разовая работа для одного (нименьшая отдача)</dt>
        <dt>Single_teamwork - разовая работа для нескольких участников под началом опытного лидера</dt>
        <dt>private_teamwork - закрытая группа из нескольких человек без опытного лидера, состав участников задается заранее и не меняется</dt>
        <dt>open_teamwork -есть ядро постоянных участников, но есть возможность разовых включений (приглашений) для других людей (1-3 чел.)</dt>
        <dt>full_teamwork - У тимворка есть 1 владелец. Остальные могут быть партнерами\постоянными или разовыми,
            владелец может менять статус участника, рассылать приглашения и тп. фулл-контроль. todo продумать!</dt>
    </dl>
    <p>
    Артели под добыче шаров (то же самое, на работаете в группе).
    Требования к иницатору группы - наличие складов, стаж по добыче > 3000 шаров, умение > 50 \ степень - мастер, гуру.
    % добычи в группе + 10, иниц-р берет часть дохода себе (норма устанавливается иниц-ром заранее) +
    работа под началом ускоряет получение опыта
    <p></p>
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-lg-4">
            {!! Form::open(['route' => 'work_mine_action', 'class' => '']) !!}
            {!! Form::label('title', 'Белые шары', ['class' => '']) !!}
            <br>
            {!! Form::label('title', 'Нужно: больше ничего', ['class' => '']) !!}
            <br>
            {!! Form::date('name', \Carbon\Carbon::now()) !!}
            <br>
            {!! Form::submit('Начать', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-lg-4">
            {!! Form::open(['route' => 'work_mine_action', 'class' => '']) !!}
            {!! Form::label('title', 'Зеленые шары', ['class' => '']) !!}
            <br>
            {!! Form::label('title', 'Нужно: (лопата, совок) (дрель)', ['class' => '']) !!}
            <br>
            {!! Form::submit('Начать', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-lg-4">
            {!! Form::open(['route' => 'work_mine_action', 'class' => '']) !!}
            {!! Form::label('title', 'Синие шары', ['class' => '']) !!}
            <br>
            {!! Form::label('title', 'Нужно: (лопата, совок) (агрегат, жидкость)', ['class' => '']) !!}
            <br>
            {!! Form::submit('Начать', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <p></p>
    {{ link_to_route('work_create_single_teamwork_page', 'Создать группу') }}
    <p></p>
    {{ link_to_route('work_create_privateteam_page', 'Создать PrivateTeam') }}

    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-lg-12">
            @if(count($offers) > 0)
                Предложения на коллективную работу (разовые)
                <p></p>
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Offer ID</th>
                            <th>LEADER</th>
                            <th>Кол-во чел.</th>
                            <th>Тип работ</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($offers as $offer)
                            <tr>
                                <td>{{ $offer->id }}</td>
                                <td>{{ $offer->leader->name }}</td>
                                <td>{{ $offer->users_count }}</td>
                                <td>{{ $offer->kind_work }}</td>
                                <td>
                                    {{ link_to_route('work_show_teamwork_conditions_page', 'Смотреть условия', ['offer_id' => $offer->id]) }}
                                </td>
                                <td>
                                    {!! Form::open(['route' => 'work_join_to_teamwork_action', 'class' => '']) !!}
                                    {!! Form::hidden('offer_id', $offer->id, ['id' =>  '']) !!}
                                    {!! Form::submit('Вступить', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>
                                    {!! Form::open(['route' => 'work_delete_single_teamwork_action', 'class' => '']) !!}
                                    {!! Form::hidden('offer_id', $offer->id, ['id' =>  '']) !!}
                                    {!! Form::submit('Удалить', array('class' => 'btn btn-warning')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Предложений нет
            @endif

        </div>
    </div>

@endsection

