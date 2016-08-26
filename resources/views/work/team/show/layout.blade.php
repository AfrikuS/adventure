@extends('layouts.app')

@section('title', 'Show Team')

@section('center')

    Условия работы в группе
    <p><p>
        Требования, бонусы
    <p><p><p>

{{--        Лидер - {{ $privateteam->leader->name }}--}}
    <p><p>
        {{--Тип работ {{ $privateteam->kind_work }}--}}
    <p><p>
        Статус группы {{ $privateteam->status }}
    <p><p>
        Состав группы
    <p><p>
    <ul>
        @foreach ($partners as $partner)
            <li>{{ $partner->name }} (id: {{ $partner->id }})</li>
        @endforeach
    </ul>


    @parent

@endsection



