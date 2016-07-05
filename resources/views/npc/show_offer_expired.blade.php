@extends('layouts.app')

@section('title', 'Npc Offer Index -  Page')
@section('head')
    @parent
@endsection

@section('center')


    <div class="row row-offcanvas">
        <div class="col-lg-4">
            {{ $offer->npc_char }} устал ждать от вас ответа и отзывает свое предложение.
            <p></p>
            {{ $offer->offer_ending }}
            <p></p>
            {{ $offer->offer_ending }}
            <p></p>
            <div class="timer" data-seconds-left={{ $offer->duration_offer }}></div>

{{--            {{ $offer->deal_ending }}--}}
        </div>
        <div class="col-lg-4">
            {{ $offer->npc_char }}
            <p>
            {{ $offer->task }}
            <p>
            {{ $offer->reward }}
            <p>
            {{ $offer->offer_status }}
            <p>
            {{ $offer->deal_status }}
            <p>
        </div>
        <div class="col-lg-4">
        </div>
    </div>

@endsection

@section('right_column')
    @parent

@endsection
