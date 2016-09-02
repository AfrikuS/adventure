@extends('employment._layout')

@section('title', 'Employment - School')
@section('head')
    @parent

@endsection

@section('center')

    Выбирай профессию. Здесь в школе будем осваивать её азы
    <p></p>
    <p></p>


    <p></p>
    @foreach($userLicenses as $userLicense)
        <p></p>

        @if ($userLicense->isExist)

            <b>Продолжить обучение </b>
            {{ link_to_route('school_classroom_page', $userLicense->domainTitle, [$userLicense->domain_id]) }}
        @else
            Купить лицензию на обучение
            <br>
            {!! Form::open(['route' => 'school_get_license_action', 'class' => '']) !!}
            {!! Form::hidden('domain_id', $userLicense->domain_id) !!}
            {!! Form::submit($userLicense->domainTitle, array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        @endif

    @endforeach

@endsection
