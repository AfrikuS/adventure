@extends('layouts.app')

@section('title', 'Npc Offer - Deal -  Page')
@section('head')
    @parent
@endsection

@section('center')


    <div class="row row-offcanvas">
        <div class="col-lg-4">
            Вы приняли предложение от {{ $offer->npc_char }}
            <p></p>
            Он ждет от вас выполнения {{ $offer->task }}
            {!! Form::open(['route' => 'npc_perform_deal_action', 'class' => '']) !!}
            {!! Form::hidden('deal_id', $offer->id) !!}
            {!! Form::submit('Выполнить задание', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
            <p></p>

        </div>
        <div class="col-lg-4">

            Награда:
            <p>
            {{ $offer->reward }}
            <p><p><p>
            {{ $offer->deal_ending }}
            <p>
            {{ $offer->deal_status }}
            <p>
            <p></p>
            <div class="timer" data-seconds-left={{ TimeHelper::leftSecs($offer->deal_ending) }}></div>
        </div>
        <div class="col-lg-4">
            {!! Form::open(['route' => 'npc_refuse_offer_page', 'class' => '']) !!}
            {!! Form::hidden('offer_id', $offer->id) !!}
            {!! Form::submit('Отказаться от выполнения', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('right_column')
    @parent

@endsection
