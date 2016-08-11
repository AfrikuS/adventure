@extends('learn._layout')

@section('center')

    mosaic_view
    <p></p>

    {{ $mosaic }}
    <p></p>
    <p></p>
    amount: <b>{{ $amount }}</b>

    <p></p>
    <p></p>

    {{ Form::open(['route' => 'learn_learn_action', 'class' => '']) }}
    {{ Form::submit('Learn', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}

    <p></p>
    <p></p>

    {{ Form::open(['route' => 'learn_restore_default_action', 'class' => '']) }}
    {{ Form::submit('to default', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}

    

@endsection
