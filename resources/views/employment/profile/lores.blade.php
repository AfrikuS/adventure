@extends('employment._layout')

@section('title', 'Employment - Index')
@section('head')
    @parent



@endsection

@section('center')

    <h3>Работа, занятость, деятельность</h3>

    @foreach($lores as $lore)

        <p></p>
        {{ $lore->domain_code }}
        <p></p>
        @include('_partials.employment.profile.lore_mosaic', ['lore' => $lore])

    @endforeach

    <p></p>
    <p></p>
    <p></p>
    <p></p>

    Мозаика знаний-умений
    <p></p>

    {{--{{ $mosaic }}--}}
    <p></p>
    <p></p>

    {{--{!! Form::open(['route' => 'employment_start_action', 'class' => '']) !!}--}}
    {{--{!! Form::submit('Start work process', array('class' => 'btn btn-danger')) !!}--}}
    {{--{!! Form::close() !!}--}}

    {{--<div id="chart1" style="height: 250px;"></div>--}}



@endsection

@section('scripts')

    <script>

        $(document).ready(function(){
            var plot1 = $.jqplot ('chart1', [[3,7,9,1,5,3,8,2,5]]);
        })

    </script>

@endsection