@extends('mine.mine_layout')

@section('title', 'Mine Index -  Page')
@section('head')
    @parent
@endsection

@section('center')

{{--<dl>--}}
    {{--<dt>Profile LINKS</dt>--}}
    {{--<dd>{{ link_to_route('work_shop_page', 'Shop') }}</dd>--}}
    {{--<dd>{{ link_to_route('work_orders_page', 'Orders list') }}</dd>--}}
    {{--<dd>{{ link_to_route('work_teamorders_page', 'TeamOrders list') }}</dd>--}}
{{--    <dd>{{ link_to_route('work_mine_page', 'Работы под добыче ресурсов') }}</dd>--}}
    {{--<dd>{{ link_to_route('work_show_privateteam_page', 'My TEam', ['id' => 1]) }}</dd>--}}
{{--</dl>--}}
{{--<dl>--}}
    {{--<dt>TEAMS</dt>--}}
    {{--<dd>{{ link_to_route('work_privateteams_page', 'Teams LIST') }}</dd>--}}
{{--</dl>--}}

http://mirnefti.ru/index.php?id=33&char=14
<p></p>

Перегонка (нефти) – процесс разделения нефти на составные



Большое количество строительных материалов, в частности битум
Вода (дистилляция\фильтрация\разогрев)
<p><p>


<br>В этом разделе добываются нефте-ресурсы.
<br><br>
<br>    Для получения ресурса нужны станки, инструменты, расходный материал, и пр. инстрментарий.
<br>    Всего наименований ресурсов 20 шт.
<br>    Самый ценный - кристально чистая вода.
<p>

<p>выпариватель - evaporater
<p>lubricant - смазка

<p>Работы по обработке.
<div class="row row-offcanvas">
    <div class="col-lg-3">
        {!! Form::open(['route' => 'mine_mine_petrol_action', 'class' => '']) !!}
        {!! Form::submit('Качать нефть', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    </div>
    <div class="col-lg-5">
        Помпа\Насос - Ускоритель добычи.
    </div>
    <div class="col-lg-4">
        Бурительный апп. \ Усислитель - добыча больше
    </div>
</div>
<div class="row row-offcanvas">
    <div class="col-lg-3">
        {!! Form::open(['route' => 'mine_mine_kerosene_action', 'class' => '']) !!}
        {!! Form::submit('Крекинг (нагрев) нефти', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    </div>
    <div class="col-lg-5">
        Катализатор
        На выходе - горючее Керосин\Бензин + Мазут
    </div>
    <div class="col-lg-4">
        Лигроин (также нафта) – вещество, получаемое при перегонке нефти
        Мазут – густая жидкость темного цвета, представляющая собой остаток после удаления из состава нефти бензиновых и керосиновых фракций, которые выкипают        Керосин (перегонка нефти) топливо для двигателей -
    </div>
</div>

<div class="row row-offcanvas">
    <div class="col-lg-4">
        {!! Form::open(['route' => 'mine_mine_oil_action', 'class' => '']) !!}
        {!! Form::submit('Коксование топлива', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    </div>
    <div class="col-lg-4">
        Clean-агрегат. Обработка, гидроочистка
        <p>Нафта (также лигроин или нефтяной спирт)
    </div>
    <div class="col-lg-4">
        Масло -(через коксование топлива), Масла смазочные, растворители
    </div>
</div>

<div class="row row-offcanvas">
    <div class="col-lg-4">
        {!! Form::open(['route' => 'mine_mine_whater_action', 'class' => '']) !!}
        {!! Form::submit('Выпаривать масла', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    </div>
    <div class="col-lg-4">
        Дистилляция масла
        <br>Другие получаются путем обработки\очищения\расщепления одного или нескольких других ресурсов
    </div>
    <div class="col-lg-4">
    </div>
</div>



@endsection

@section('right_column')
    @parent
hmvc
@endsection
