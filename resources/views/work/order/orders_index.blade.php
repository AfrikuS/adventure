@extends('layouts.app')

@section('title', 'Work - Single Orders')
@section('head')
    @parent
@endsection

@section('center')

    Список заказов на постройку.
    <p></p>

    <div class="row text-center pad-top">
        <div class="col-lg-12">
            @if(count($orders) > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>accept</th>
                            <th>desc</th>
                            <th>price</th>
                            <th>acceptor</th>
                            <th>status</th>
                            <th>show</th>
                            <th>del</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    {!! Form::open(['route' => 'work_accept_order_action', 'class' => 'form-signup']) !!}
                                    {!! Form::hidden('order_id', $order->id, []) !!}
                                    {!! Form::submit('Accept', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>{{ $order->desc }}</td>
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->acceptor_user_id | 'no' }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ link_to_route('work_show_order_page', 'Выбрать', ['id' => $order->id]) }}</td>
                                <td>{{ link_to_route('work_delete_order_action', 'Del', ['id' => $order->id]) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Заказов сйечас нет
            @endif
        </div>
    </div>

    <div class="row text-center pad-top">
        <div class="col-lg-12">
            Ваши заказы
            <p>
            @if(count($workerOrders) > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>price</th>
                            <th>acceptor_id</th>
                            <th>status</th>
                            <th>show</th>
                            <th>del</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($workerOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->acceptor_user_id }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ link_to_route('work_show_order_page', 'Выбрать', ['id' => $order->id]) }}</td>
                                <td>{{ link_to_route('work_delete_order_action', 'Del', ['id' => $order->id]) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Заказов сйечас нет
            @endif
        </div>
    </div>





    <div class="row text-center pad-top">
        <div class="col-lg-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h4>Построить баню</h4>
                </div>
                <div class="panel-body">

                    <ul class="plan">
                        <li class="price"><strong>990</strong> <i class="fa fa-dollar"></i></li>
                        <li><strong>52</strong> бревен</li>
                        <li><strong>50 GB</strong> утеплитель</li>
                        <li><strong>Free</strong> топка</li>
                        <li><strong>Free</strong> шифер</li>
                        <li><strong>Free</strong> <strike>фундамент</strike></li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <a href="#" class="btn btn-danger ">BUY NOW</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Сделать бассейн</h4>
                </div>
                <div class="panel-body">

                    <ul class="plan">
                        <li class="price"><strong>2500</strong> <i class="fa fa-dollar"></i></li>
                        <li><strong>52</strong> <strike>выкопать яму</strike></li>
                        <li><strong>50 GB</strong> обложить плиткой</li>
                        <li><strong>Free</strong> поставить трамплин</li>
                        <li><strong>Free</strong> обложить плиткой подходы</li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <a href="#" class="btn btn-primary ">BUY NOW</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('right_column')

    @parent

    {!! Form::open(['route' => 'generate_work_order_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Сгенерить заказ', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endsection

