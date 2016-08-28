@extends('layouts.app')

@section('center')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Поиск противника</div>
                <div class="panel-body">
                    Последние нападения
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>USER ID</th>
                            <th>User_name</th>
                            <th>Осталось время до нападения</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($attacks as $attack)
                                <tr>
                                    <td>{{ $attack->defense_user_id }}</td>
                                    <td>{{ $attack->name }}</td>
                                    @if ($attack->duration_seconds > 0)
                                        <td><div class="timer" data-seconds-left={{ $attack->duration_seconds }}></div></td>
                                    @else
                                        <td>
                                            {!! Form::open(['roue' => 'attack_enemy_action', 'class' => '']) !!}
                                            {!! Form::hidden('user_id', $attack->defense_user_id, ['id' =>  '']) !!}
                                            {!! Form::submit('Напасть', array('class' => 'btn btn-primary')) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <p></p>
            <p>
            {!! Form::open(['route' => 'search_enemy_action', 'class' => '']) !!}
            {!! Form::submit('Искать случайного соперника', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>

    </div>
@endsection
