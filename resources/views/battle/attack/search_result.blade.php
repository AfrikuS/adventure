@extends('layouts.app')

@section('title', 'Battle -  Search Result')

@section('center')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Вам встретился</div>

                <div class="panel-body">

                    {{--{{ var_dump($users_ids) }}--}}
                    {{ $user->name }}

                    <p>
                    {!! Form::open(['action' => ['Battle\AttackController@searchOpponent'], 'class' => '']) !!}
                    {!! Form::submit('Искать снова', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                    <p>
                    {!! Form::open(['action' => ['Battle\AttackController@attack'], 'class' => '']) !!}
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

