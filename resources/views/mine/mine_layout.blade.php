@extends('layouts.app')


@section('left_column')

    <dl>
        <dt>Mine links</dt>
        <dd><a href="/macro">На площадь</a></dd>
        <dd><a href="/macro/buildings">Минитср строитеьства</a></dd>
        <dd><a href="/macro/exchange">Точка обмена</a></dd>
        <dd><a href="/macro/obtain">Добыча ресурсов</a></dd>
    </dl>

@endsection


@section('right_column')
    Mine-ресурсы
    <ul>
        <li>Нефть: {{ $miner->petrol }}</li>
        <li>Керосин: {{ $miner->kerosene }}</li>
        <li>Масло: {{ $miner->oil }}</li>
        <li>Вода: {{ $miner->whater }}</li>
    </ul>

@endsection
