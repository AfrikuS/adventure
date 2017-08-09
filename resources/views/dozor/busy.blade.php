@extends('layouts.app')

@section('title', 'Bodalka Waiting Page')
@section('head')
    @parent
@endsection

@section('center')


    Вы ушли в дозор. Вернетесь через
    <div class="timer" data-seconds-left={{ $uptime }}></div>

@endsection




