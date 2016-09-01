@extends('employment._layout')

@section('title', 'Employment - School')
@section('head')
    @parent

@endsection

@section('center')

    Выбирай профессию, будем осваивать её азы
    <p></p>
    <p></p>


    <p></p>
    @foreach($remainingDomains as $domain)
        <p></p>

        @if ($domain->isLicense)

            <b>Продолжить обучение </b>
            {{ link_to_route('school_classroom_page', $domain->title, [$domain->id]) }}
        @else
            Купить лицензию на обучение
            <br>
            {!! Form::open(['route' => 'school_get_license_action', 'class' => '']) !!}
            {!! Form::hidden('domain_id', $domain->id) !!}
            {!! Form::submit($domain->title, array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        @endif

    @endforeach

@endsection
