@extends('profile._layout')

@section('title', 'Base - OilPump Page')
@section('head')
    @parent
@endsection

@section('center')

    @if ($oilPump->level === 0)

        Нефтенасос надо сперва установить

        <p></p>
        <p></p>

        {!! Form::open(['route' => 'base_oilpump_upgrade_action', 'class' => '']) !!}
        {!! Form::submit('Установить', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

    @else

        Нефтенасос прокачан до {{ $oilPump->level }} уровня

        <p></p>
        <p></p>

        @if ($oilPump->level < 6)

            {!! Form::open(['route' => 'base_oilpump_upgrade_action', 'class' => '']) !!}
            {!! Form::submit('Улучшить', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}

            <p></p>
            <p></p>

        @endif

        {!! Form::open(['route' => 'base_oilpump_process_action', 'class' => '']) !!}
        {!! Form::submit('Качать нефть', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

    @endif


@endsection