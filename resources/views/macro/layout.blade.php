@extends('layouts.app')

@section('left_column')

    <dl>
        <dt>Macro links</dt>
        <dd><a href="/macro">На площадь</a></dd>
        <dd><a href="/macro/buildings">Минитср строитеьства</a></dd>
        <dd><a href="/macro/exchange">Точка обмена</a></dd>
        <dd><a href="/macro/obtain">Добыча ресурсов</a></dd>
    </dl>

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
