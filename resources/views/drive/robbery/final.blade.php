@extends('drive.robbery.layout')

@section('title', 'Robbery - Finish')

@section('center')

        Вы легко взломали ворота и въехали во двор, пробраться во внутренний двор мешает забор,
        <br>трещин и скрытых ходов не видно. Вы решаете ехать прямо напролом
        <p></p>
        <h3>Разбой окончен</h3>
        <p></p>

        {!! Form::open(['route' => 'drive_robbery_finish_action', 'class' => '']) !!}
        {!! Form::submit('Вернуться в поле', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

        <p></p>
        <p></p>
        {!! Form::open(['route' => 'drive_robbery_driveto_gates_action', 'class' => '']) !!}
        {!! Form::submit('Вернуться к воротам', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}


@endsection
