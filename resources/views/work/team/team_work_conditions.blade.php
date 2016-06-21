@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('left_column')
    <dl>
        <dt>Profile LINKS</dt>
        <dd><a href="/work">Виды работ</a></dd>
        <dd><a href="/work/mine">Работы под добыче ресурсов</a></dd>
    </dl>

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

