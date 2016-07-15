@extends('drive.robbery.layout')

@section('title', 'Robbery - Crush Result')

@section('center')

    Несмотря на сильный удар {{ $result->building }} устоял[а]
    <p></p>

    Сила удара тачки  : <b>{{ $result->vehiclePower }}</b>
    <p></p>
    Стойкость {{ $result->building }} :  <b>{{ $result->buildingDuracity }}</b>
    <p></p>


    <p></p>
    Урон нанесенный {{ $result->building }} составил {{ $result->buildingDamage }} единиц
    <p></p>
    Машине нанесено {{ $result->vehicleDamage }} урона
    <p></p>
    <h3>ТЫ не пройдешь!!!</h3>
    <p></p>
    <p></p>
    <p></p>
    {{--<h3>*Забор после ворот*</h3>--}}
    <p></p>

    <b>{{ link_to_route('drive_robbery_page', 'Back') }}</b>

{{--    {!! Form::open(['route' => 'drive_robbery_drivein_fence_action', 'class' => '']) !!}--}}

{{--    @include('drive.robbery._specials')--}}

{{--    {!! Form::submit('Въехать снова', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}


@endsection