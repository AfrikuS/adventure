@extends('layouts.app')

@section('head')
    @parent

@endsection


@section('left_column')
    @parent
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Вам встретился</div>

                <div class="panel-body">

                    {{ var_dump($users_ids) }}
                    {{ $user->name }}

                    <p>
                    {!! Form::open(['action' => ['AttackController@searchOpponent'], 'class' => '']) !!}
                    {!! Form::submit('Искать снова', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                    <p>
                    {!! Form::open(['action' => ['AttackController@attack'], 'class' => '']) !!}
                    {!! Form::hidden('user_id', $user->id, ['id' =>  '']) !!}
                    {!! Form::submit('Напасть', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                    <p>
                    <a href="/search">Назад на страницу посика</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('right_column')
    @parent
@endsection
