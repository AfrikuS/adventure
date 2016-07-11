@extends('layouts.app')

@section('left_column')

    <ul>
        <li>Macro links</li>
        <li><a href="/macro">На площадь</a></li>
        <li><a href="/macro/buildings">Минитср строитеьства</a></li>
        <li><a href="/macro/exchange">Точка обмена</a></li>
        <li><a href="/macro/obtain">Добыча ресурсов</a></li>
    </ul>

@endsection



@section('right_column')
    Макро-ресурсы
    <ul>
        <li>Еда: {{ $resources->food }}</li>
        <li>Дерево: {{ $resources->tree}}</li>
        <li>Вода: {{ $resources->water }}</li>
        <li>Свободные жители: {{ $resources->free_people }}</li>
    </ul>
    <p>
@endsection
