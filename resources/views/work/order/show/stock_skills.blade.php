@extends('work.order.show.layout')


@section('stock_skills')

    <p></p><p></p><p></p>
    <B>Вид работ: {{ $domain->title }}</B>
    <p></p>
    <B>Вознаграждение: {{ $order->price }}</B>
    <p></p>


    {{--Необходимый навык\спец-ть:--}}
    <p></p>
    {{--<b>{{ $orderSkill->code }}</b>--}}
    <p></p>
    Надо    : {{ $orderSkill->needTimes }}
    Сделано : {{ $orderSkill->stockTimes }}
    <p></p>



    Можно начинать работы.
    <p></p>
        Кнопка начать работы (указано время работ)
    <p></p>
    {!! Form::open(['route' => 'work_order_apply_skill_action', 'class' => 'form-signup']) !!}
    {!! Form::hidden('order_id', $order->id, []) !!}
    {!! Form::submit('Начать работу', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>



    Ваши знания по данной спец-ти: <b>{{ $domain->title }}</b>
    <p></p>
    {{ $lore->present()->mosaicTable }}


@endsection