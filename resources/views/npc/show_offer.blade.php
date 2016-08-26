@extends('layouts.app')

@section('title', 'Npc Offer Index -  Page')
@section('head')
    @parent
@endsection

@section('center')


    <div class="row row-offcanvas">
        <div class="col-lg-4">
            {!! Form::open(['route' => 'npc_accept_offer_page', 'class' => '']) !!}
            {!! Form::hidden('offer_id', $offer->id) !!}
            {!! Form::submit('Принять предложение', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
            <p></p>
            {{ $offer->offer_ending }}
            <p></p>
            <div class="timer" data-seconds-left={{ TimeHelper::leftSecs($offer->offer_ending) }}></div>

        </div>
        <div class="col-lg-4">
            {{ $offer->npc_char }}
            <p>
            {{ $offer->task }}
            <p>
            {{ $offer->reward }}
            <p>
            Status: <b>{{ $offer->offer_status }}</b>
            <p>
            {{--{{ $offer->deal_status }}--}}
            <p>
        </div>
        <div class="col-lg-4">
            {!! Form::open(['route' => 'npc_refuse_offer_action', 'class' => '']) !!}
            {!! Form::hidden('offer_id', $offer->id) !!}
            {!! Form::submit('Отклонить предложение', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('right_column')
    @parent

@endsection
