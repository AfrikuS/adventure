@extends('work.team.show.layout')


@section('center')

    @parent

    Оставить заявку на добавление в группу
    {!! Form::open(['route' => 'work_privateteam_offerjoin_action', 'class' => '']) !!}
    <br>
    {!! Form::hidden('privateteam_id', $privateteam->id, ['id' =>  '']) !!}
    <br>
    {!! Form::submit('Offer to team', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}


@endsection
