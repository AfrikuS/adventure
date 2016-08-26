@extends('layouts.app')

@section('title', 'Npc Offer - Deal -  Page')
@section('head')
    @parent
@endsection

@section('center')


    <div class="row row-offcanvas">
        <div class="col-lg-4">
            Вы приняли предложение от {{ $deal->npc_char }}
            <p></p>
            Он ждет от вас выполнения {{ $deal->task }}
            {!! Form::open(['route' => 'npc_perform_deal_action', 'class' => '']) !!}
            {!! Form::hidden('deal_id', $deal->id) !!}
            {!! Form::submit('Выполнить задание', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
            <p></p>

        </div>
        <div class="col-lg-4">

            Награда:
            <p>
            {{ $deal->reward }}
            <p><p><p>
            {{ $deal->deal_ending }}
            <p>
            {{ $deal->deal_status }}
            <p>
            <p></p>
            <div class="timer" data-seconds-left={{ TimeHelper::leftSecs($deal->deal_ending) }}></div>
        </div>
        <div class="col-lg-4">
            {!! Form::open(['route' => 'npc_refuse_offer_action', 'class' => '']) !!}
            {!! Form::hidden('offer_id', $deal->id) !!}
            {!! Form::submit('Отказаться от выполнения', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('right_column')
    @parent

@endsection
