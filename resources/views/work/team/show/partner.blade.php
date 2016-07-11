@extends('work.team.show.layout')


@section('center')

    @parent


    <p><p><p>

    {!! Form::open(['route' => 'work_leave_privateteam_action', 'class' => '']) !!}
    {!! Form::hidden('privateteam_id', $privateteam->id, ['id' =>  '']) !!}
    <br>
    {!! Form::submit('Выйти из private-team', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

    <p><p><p>

@endsection

