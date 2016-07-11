@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('left_column')
    <ul>
        <li>Profile LINKS</li>
        <li><a href="/work">Виды работ</a></li>
        <li><a href="/work/mine">Работы под добыче ресурсов</a></li>
    </ul>

@endsection

@section('center')

    Условия работы в группе
    <p><p>
    Требования, бонусы
    <p><p><p>

Лидер - {{ $offer->leader->name }}
    <p><p>
Тип работ {{ $offer->kind_work }}

@endsection

