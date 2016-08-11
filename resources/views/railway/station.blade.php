@extends('railway._layout')

@section('title', 'Railway - Station Trains')
@section('head')
    @parent
@endsection

@section('center')

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>LOT ID</th>
                {{--<th>Title</th>--}}
                <th>Время до прибытия поезда</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($nearTrains as $nearTrain)
                <tr>
                    <td>{{ $nearTrain->conductor_id }}</td>
                    {{--<td><div class="timer" data-seconds-left={{ $activeTrain->active_seconds }}></div></td>--}}
                    <td><div class="timer" data-seconds-left={{ $nearTrain->duration_seconds }}></div></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Train ID</th>
                <th>Conductor</th>
                <th>Resources</th>
                <th>Action</th>
                <th>Время до отправления</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activeTrains as $activeTrain)
                <tr>
                    <td>{{ $activeTrain->id }}</td>
                    <td>{{ $activeTrain->conductor->name }}</td>
                    <td>Ресурсы на поезде</td>
                    <td>
                        {!! Form::open(['route' => 'meeting_with_conductor_action', 'class' => 'form-signup']) !!}
                        {!! Form::hidden('train_id', $activeTrain->id) !!}
                        {!! Form::submit('Подойти к нач. поезда', array('class' => 'btn btn-success')) !!}
                        {!! Form::close() !!}

                    </td>
                    <td><div class="timer" data-seconds-left={{ $activeTrain->duration_seconds }}></div></td>
                </tr>
            @endforeach
            </tbody>
        </table>


@endsection


@section('right_column')

    @parent

    {!! Form::open(['route' => 'railway_generate_train_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Сгенерить train', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'railway_delete_old_trains_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Rm old trains', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}

@endsection
