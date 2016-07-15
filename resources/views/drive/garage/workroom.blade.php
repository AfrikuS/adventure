@extends('drive.garage._layout')

@section('title', 'Drive -  Garage Work_Room')


@section('center')

    Vehicle Repair-State in percents
    <p></p>
    Just repair details
    <p></p>
    Instruments List : inspection_pit (смотровая яма), vehicle_elevator\lift (подъемник),
    diagnostic_device (диагноситич устройсвто) with some degrees, jack (домкрат)
    <p></p>

    Степень повреждений: <b>{{ $vehicle->damage_percent }}</b> %
    <p></p>
    Уровень топлива: <b>{{ $vehicle->fuel_level }}</b> л.
    <p></p>
    <p></p>
    Общее состояние: <b>{{ $vehicle->status }}</b>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_repair_action', 'class' => '']) !!}
    {!! Form::submit('Починить на 10 %', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_refuel_action', 'class' => '']) !!}
    {!! Form::submit('Заправиться -> 10 л.', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_recovery_action', 'class' => '']) !!}
    {!! Form::submit('Hard Recovery -> 80 %', array('class' => 'btn btn-danger')) !!}
    {!! Form::close() !!}
    <p></p>
    <p></p>
    Pit-Stop - Vehicle Reapir Business
    <p></p>
    Покупка обрудувания, ремонт, диагностика. С опытом и новым оборудованием - ремонт качественнее и быстрее,
    цены на ремонт - ставишь сам (в разумных лимитах)
    <p></p>

@endsection
