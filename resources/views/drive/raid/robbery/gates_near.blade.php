@extends('drive.raid.robbery._layout')

@section('title', 'Robbery - Gates Near')

@section('center')

    Вы подъехали поближе и видите (подробное описание ворот, имя владельца).
    <p></p>
    Самое время выбрать тактику боя
    <p></p>
    Стойкость ворот ок. {{ $gates_durability }}
    <p></p>
    Варианты:
    <p></p>
    <p></p>
    <h3>Перед вратами</h3>
    <p></p>

    {!! Form::open(['route' => 'drive_robbery_drivein_gates_action', 'class' => '']) !!}

{{--    @include('drive.raid.robbery._specials')--}}

    {!! Form::submit('Въехать в ворота', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>




@endsection
    