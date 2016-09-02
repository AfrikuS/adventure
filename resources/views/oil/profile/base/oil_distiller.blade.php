@extends('profile._layout')

@section('title', 'Base - Oil-Distiller Page')
@section('head')
    @parent
@endsection

@section('center')

    @if ($distiller->level === 0)

        Нефте-Дистиллятор надо сперва установить

        <p></p>
        <p></p>

        {!! Form::open(['route' => 'base_oil_distiller_upgrade_action', 'class' => '']) !!}
        {!! Form::submit('Установить', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

    @else

        Нефте-Дистиллятор прокачан до {{ $distiller->level }} уровня

        <p></p>
        <p></p>

        @if ($distiller->level < 6)

            {!! Form::open(['route' => 'base_oil_distiller_upgrade_action', 'class' => '']) !!}
            {!! Form::submit('Улучшить', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}

            <p></p>
            <p></p>

        @endif

        {!! Form::open(['route' => 'base_oil_distiller_process_action', 'class' => '']) !!}
        {!! Form::submit('Перегонять нефть', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

    @endif


@endsection