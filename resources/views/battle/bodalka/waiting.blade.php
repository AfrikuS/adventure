@extends('layouts.app')

@section('title', 'Bodalka Waiting Page')
@section('head')
    @parent
@endsection

@section('center')


    Отдых после боя
    <div class="timer" data-seconds-left={{ $timer->duration_seconds }}></div>

@endsection




