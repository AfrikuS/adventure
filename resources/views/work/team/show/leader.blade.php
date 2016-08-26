@extends('work.team.show.layout')


@section('center')

    @parent

    <p></p>
    @if (count($joinOffers) > 0)
        Добавить юзера в группу
        <p></p>
        <ul>
        @foreach($joinOffers as $offer)
            <li>{{ $offer->user->name }} -> {{ $offer->worker_id }}</li>
            <li>
                {!! Form::open(['route' => 'work_team_accept_offer_action', 'class' => '']) !!}
                {!! Form::hidden('offer_id', $offer->id) !!}
                {!! Form::submit('Принять в команду', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </li>
            <li>
                {!! Form::open(['route' => 'work_team_refuse_offer_action', 'class' => '']) !!}
                {!! Form::hidden('offer_id', $offer->id) !!}
                {!! Form::submit('Отказать', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </li>
        @endforeach
        </ul>
    @else
        Заявок на вступление нет
    @endif
    <p></p>

    <p><p><p>

    {!! Form::open(['route' => 'work_delete_privateteam_action', 'class' => '']) !!}
    {!! Form::hidden('playouts.apprivateteam_id', $privateteam->id, ['id' =>  '']) !!}
    <br>
    {!! Form::submit('Распустить private-team', ['class' => 'btn btn-warning']) !!}
    {!! Form::close() !!}

    <p><p><p>

    Доли при делении дохода в %-ах
    <p></p>
    <ul>
    @foreach($pies as $pie)
        <li>{{ $pie->worker_id }} -> {{ $pie->amount_percent }} %</li>
    @endforeach
    </ul>

    {{--Подтвердить состав группы--}}
    {{--{!! Form::open(['route' => 'work_commit_privateteam_action', 'class' => '']) !!}--}}
    {{--<p>--}}
    {{--{!! Form::hidden('privateteam_id', $privateteam->id, ['id' =>  '']) !!}--}}
    {{--<p>--}}
    {{--{!! Form::submit('Commit team group', ['class' => 'btn btn-primary']) !!}--}}
    {{--{!! Form::close() !!}--}}


@endsection
