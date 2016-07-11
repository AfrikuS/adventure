@extends('admin.admin_layout')

@section('title', 'Admin - Index')
@section('head')
    @parent
@endsection

@section('center')

    <h4>Админка</h4>

    {{ link_to_route('admin_orderdrafts_page', 'Конструктор заказов') }}
    <p></p>
    {{ link_to_route('admin_locations_page', 'Редактор локаций') }}
    <p></p>

    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Награды</a></li>
        <li role="presentation"><a href="#">Тайминги</a></li>
        <li role="presentation"><a href="#">Messages</a></li>
    </ul>
    <p><p><p>


@endsection
