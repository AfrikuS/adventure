@extends('admin.orders.layout')

@section('title', 'Team-Order-Builder. Main Draft Page')
@section('head')
    @parent
@endsection

@section('window')

    <div class="row row-offcanvas">
        <h4>Cоздать team-order</h4>
        <div class="col-lg-6">
            <h4>Материалы</h4>

            @if (count($materials) > 0)
                <ul>
                    @foreach($materials as $material)
                        <li>
                            {{ $material->code }} - {{ $material->need }}
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>

        <div class="col-lg-6">
            <h4>Навыки</h4>

            @if (count($skills) > 0)
                <ul>
                    @foreach($skills as $skill)
                        <li>
                            {{ $skill->code }} - {{ $skill->need_times }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
            <h4>Данные заказа</h4>
            <p>
            <p>'Цена': {{ $orderDraft->price }}
            <p>'Описание': {{ $orderDraft->desc }}
            <p>'Доп. сведения': {{ $orderDraft->kind_work_title }}
        </div>

        <div class="col-lg-6">
            {{--<h4>Выберите строй-инструменты</h4>--}}
            {{--@if (count($instruments) > 0)--}}
                {{--<ul>--}}
                    {{--@foreach($instruments as $instrument)--}}
                        {{--<li>--}}
                            {{--{{ Form::checkbox('instruments[]', $instrument->id) }}--}}
                            {{--{{ Form::label('instrument_'.$instrument->code , $instrument->title) }}--}}
                        {{--</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--@endif--}}
            {!! Form::open(['route' => 'admin_publish_orderdraft_action', 'class' => '']) !!}
            {!! Form::hidden('draft_id', $orderDraft->id) !!}
            {!! Form::submit('Publish', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection


