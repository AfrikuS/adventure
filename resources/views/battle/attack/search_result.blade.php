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
                    {!! Form::open(['route' => 'search_enemy_action']) !!}
                    {!! Form::submit('Искать снова', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                    <p>
                    {!! Form::open(['route' => 'attack_enemy_action']) !!}
                    {!! Form::hidden('user_id', $user->id) !!}
                    {!! Form::submit('Напасть', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                    <p>
                    {{ link_to_route('search_page', 'Назад на страницу посика') }}
                </div>
            </div>
        </div>
    </div>
@endsection

