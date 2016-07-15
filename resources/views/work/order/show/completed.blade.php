@extends('work.order.show.layout')



@section('completed')

    <p></p>
    <B>Вознаграждение: {{ $order->price }}</B>
    <p></p>
    <p></p>

    Заказ выполнен. Получить награду.

@endsection