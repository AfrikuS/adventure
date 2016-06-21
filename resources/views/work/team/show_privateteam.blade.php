@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('center')

    Условия работы в группе
    <p><p>
        Требования, бонусы
    <p><p><p>

        Лидер - {{ $privateteam->leader->name }}
    <p><p>
        Тип работ {{ $privateteam->kind_work }}
    <p><p>
        Статус группы {{ $privateteam->status }}
    <p><p>
        Состав группы
    <p><p>
    <ul>
        @foreach ($privateteam->partners as $partner)
            <li>{{ $partner->user->name }} (id: {{ $partner->id }})</li>
        @endforeach
    </ul>

    Добавить юзера в группу
    {!! Form::open(['route' => 'work_add_partner_to_privateteam_action', 'class' => '']) !!}
    {!! Form::label('title', 'Добавить юзера по его ID', ['class' => '']) !!}
    <br>
    {!! Form::text('worker_id', '', ['id' =>  '']) !!}
    <br>
    {!! Form::hidden('privateteam_id', $privateteam->id, ['id' =>  '']) !!}
    <br>
    <br>
    {!! Form::submit('Add to team', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

    <p><p><p>

    {!! Form::open(['route' => 'work_delete_privateteam_action', 'class' => '']) !!}
    {!! Form::hidden('privateteam_id', $privateteam->id, ['id' =>  '']) !!}
    <br>
    {!! Form::submit('Удалить private-team', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

    <p><p><p>

    {!! Form::open(['route' => 'work_leave_privateteam_action', 'class' => '']) !!}
    {!! Form::hidden('privateteam_id', $privateteam->id, ['id' =>  '']) !!}
    <br>
    {!! Form::submit('Выйти из private-team', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

    {{--Подтвердить состав группы--}}
    {{--{!! Form::open(['route' => 'work_commit_privateteam_action', 'class' => '']) !!}--}}
    {{--<p>--}}
    {{--{!! Form::hidden('privateteam_id', $privateteam->id, ['id' =>  '']) !!}--}}
    {{--<p>--}}
    {{--{!! Form::submit('Commit team group', ['class' => 'btn btn-primary']) !!}--}}
    {{--{!! Form::close() !!}--}}


@endsection

