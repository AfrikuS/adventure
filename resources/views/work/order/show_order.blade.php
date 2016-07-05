@extends('layouts.app')

@section('title', 'Show Individual Order')

@section('center')

    Чтобы начать работу нужно сперва запастись строй-материалами.
    <br>Строй-материалы можно купить в {{ link_to_route('work_shop_page', 'магазине') }} или
    на частных складах. О местоположении таких складов можно узнать из новостей. Также некоторые благодарные
    клиенты-заказчики делятся с вами этой информацией.
    <p><p>Для некоторых видов работ вам понадобятся инструменты, их также можно приобрести в магазине
    или купить на аукционе
    <p></p>
    После выполнения работ вы получаете вознаграждение и прокачиваете свой скилл по данному виду работ
    <p></p><p></p><p></p>
    <B>Вид работ: {{ $order->kind_work_title }}</B>
    <p></p>
    <B>Вознаграждение: {{ $order->price }}</B>
    <p></p>
    <div class="row row-offcanvas">
        <div class="col-lg-8 col-sm-8">
            Материалы необходимые для начала работ
            <p></p>
            @if ($orderMaterials != null)
                <ul>
                    <li>Материал \ Сколько надо \ Сколько внесено</li>
                    @foreach($orderMaterials as $material)
                        <li>{{ $material->code . " - "  .$material->need . " - " . $material->stock}}</li>
                        @if ($material->need > $material->stock)
                            {!! Form::open(['route' => 'work_order_add_material_in_stock_action', 'class' => 'form-signup']) !!}
                            {!! Form::hidden('material', $material->code, []) !!}
                            {!! Form::hidden('order_id', $order->id, []) !!}
                            {!! Form::submit('Внести ' . $material->code, array('class' => 'btn btn-primary')) !!}
                            {!! Form::close() !!}
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="col-lg-4 col-sm-4">
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

    @if($orderReady)
        Можно начинать работы.
        <p>
        Кнопка начать работы (указано время работ)
        <p>
        {!! Form::open(['route' => 'work_order_apply_skill_action', 'class' => 'form-signup']) !!}
        {!! Form::hidden('order_id', $order->id, []) !!}
        {!! Form::submit('Начать работу', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    @endif
@endsection

@section('right_column')

    @parent

    {{--{!! Form::open(['route' => 'work_order_estimate_action', 'class' => 'form-signup']) !!}--}}
    {{--{!! Form::hidden('order_id', $order->id, []) !!}--}}
    {{--{!! Form::submit('Оценить работу', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}

@endsection
