@extends('drive.robbery.layout')

@section('title', 'Robbery - CourtYard')


@section('center')

    Забор остался позади, вы въехали во внутренний двор и перед вами три больших двери.
    (Описание прокачки дверей). Перед вами стоит выбор в какую дверь въехать. За каждой из них
    <br>своя награда.
    Места для разгона нет, вы собираетесь с силами, чтобы взломать последнюю дверь.

    <br>
    <p></p>
    <h3>Внутренний двор</h3>
    <p></p>
    Ваши действия
    <p></p>
    {!! Form::open(['route' => 'drive_robbery_drivein_ambar_action', 'class' => '']) !!}
    {!! Form::submit('Въехать в дверь Амбара', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>

    {!! Form::open(['route' => 'drive_robbery_drivein_house_action', 'class' => '']) !!}
    {!! Form::submit('Въехать в дверь Жилища', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>
    {!! Form::open(['route' => 'drive_robbery_drivein_warehouse_action', 'class' => '']) !!}
    {!! Form::submit('Въехать в дверь Ресурсного склада', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}


@endsection
    