@extends('layouts.app')


@section('left_column')

    <ul>
        <li>Mine links</li>
        <li><a href="/macro">На площадь</a></li>
        <li><a href="/macro/buildings">Минитср строитеьства</a></li>
        <li><a href="/macro/exchange">Точка обмена</a></li>
        <li><a href="/macro/obtain">Добыча ресурсов</a></li>
    </ul>

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
