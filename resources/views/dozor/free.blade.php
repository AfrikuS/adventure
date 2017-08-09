@extends('layouts.app')

@section('title', 'Dozor Index')

@section('head')
    @parent

@endsection


@section('center')


    <div class="row row-offcanvas">
        <div class="col-lg-12">



            <p></p>

            {!! Form::open(['route' => 'dozor_start_quest_action', 'class' => 'form-signup']) !!}
            {!! Form::submit('Пойти в дозор!', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
            {!! Form::close() !!}


        </div>
    </div>

@endsection
