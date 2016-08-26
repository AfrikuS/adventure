@extends('drive.raid.robbery._layout')

@section('title', 'Robbery - Crush Result')

@section('center')

    От такого удара {{ $result->building }} раскрылась.
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
    <p></p>

    Вы получаете {{ $result->reward }} золота
    {{--Стойкость {{ $result->building }} стостовляет {{ $result->buildingDamage }}--}}
    <p></p>
    <h2>Добро пожаловать !!!</h2>
    <p></p>
    {{--<h3>*Забор после ворот*</h3>--}}
    <p></p>

    {{ link_to_route('drive_robbery_page', 'Продолжить налет') }}


    {{--Вы легко взломали *ворота и въехали во двор*, пробраться *во внутренний двор мешает забор,--}}
    {{--<br>трещин и скрытых ходов не видно*.--}}
    {{--<p></p>--}}
    {{--Вы решаете ехать прямо напролом--}}
    {{--<p></p>--}}
    {{--<h3>Забор после ворот</h3>--}}
    {{--<p></p>--}}

    {{--{!! Form::open(['route' => 'drive_robbery_drivein_fence_action', 'class' => '']) !!}--}}

    {{--@include('drive.robbery._specials')--}}

    {{--{!! Form::submit('Въехать в забор', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}


@endsection