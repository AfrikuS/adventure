@extends('work.order.show.layout')



@section('completed')

    <B>Вознаграждение: {{ $order->price }}</B>
    <p></p>

    Заказ выполнен. Получить награду.

@endsection