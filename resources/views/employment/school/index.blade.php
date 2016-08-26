@extends('employment._layout')

@section('title', 'Employment - School')
@section('head')
    @parent



@endsection

@section('center')

    Выбирай сферу, вермя проходить начальный курс
    <p></p>
    <p></p>

{{--    {!! Form::open(['route' => 'school_get_building_license_action', 'class' => '']) !!}--}}
{{--    {!! Form::submit('Строительство', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}


    <p></p>
    @foreach($remainingDomains as $domain)
        <p></p>

        {!! Form::open(['route' => 'school_get_license_action', 'class' => '']) !!}
        {!! Form::hidden('code', $domain->code) !!}
        {!! Form::submit($domain->title, array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

    @endforeach

    <p></p>
    @foreach($userDomains as $domain)
        <p></p>

        {{ link_to_route('school_classroom_page', $domain->title, ['code' => $domain->id]) }}

    @endforeach




@endsection
