@extends('layouts.app')

@section('title', 'Show Team Order')

@section('center')

    Здесь вы работаете в команде,хоть и можно всю работу сделать в одиночку... бла-бла
    Чтобы начать работу нужно сперва запастись строй-материалами.
    <br>Строй-материалы можно купить в {{ link_to_route('work_shop_page', 'магазине') }} или
    на частных складах. О местоположении таких складов можно узнать из новостей. Также некоторые благодарные
    клиенты-заказчики делятся с вами этой информацией.
    <p><p>Для некоторых видов работ вам понадобятся инструменты, их также можно приобрести в магазине
        или купить на аукционе
    <p></p>
    После выполнения работ вы получаете вознаграждение и прокачиваете свой скилл по данному виду работ
    <p></p><p></p><p></p>
    {{--<B>Вид работ: {{ $order->kind_work }}</B>--}}
    {{--<p></p>--}}
    <B>Вознаграждение: {{ $order->price }}</B>
    <p></p>
    <B>Type: {{ $order->type }}</B>
    <p></p>
    <B>Status: {{ $order->status }}</B>
    <p></p>


    @yield('accepted')

    @yield('stock_materials')

    @yield('stock_skills')

    @yield('completed')

@endsection



