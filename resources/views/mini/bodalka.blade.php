@extends('layouts.app')

@section('title', 'Bodalka Page')
@section('head')
    @parent
@endsection

@section('center')


    @if($timer)
        Отдых после боя
        <div class="timer" data-seconds-left={{ $timer->duration_seconds }}></div>
    @else
        {!! Form::open(['route' => 'bodalka_start_action', 'class' => 'form-signup']) !!}
        {!! Form::submit('Бодаться (таймаут 5 минут)', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
        {!! Form::close() !!}
    @endif

@endsection
