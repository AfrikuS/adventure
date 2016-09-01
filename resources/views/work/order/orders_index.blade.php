@extends('work.work_layout')


@section('title', 'Work - Single Orders')
@section('head')
    @parent
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>--}}
@endsection

@section('center')

    Список заказов на постройку.
    <p></p>
{{--    @include('_partials.hb_test', array('title' => 'TITLE', 'body' => 'BADY', 'orders' => $orders))--}}
{{--    @include('_partials.order_items', ['orders' => $orders])--}}

    <div class="row text-center pad-top">
        <div class="col-lg-12">
            @if(count($orders) > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>accept</th>
                            <th>price</th>
                            <th>acceptor</th>
                            <th>domain</th>
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
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->acceptor_worker_id | 'no' }}</td>
                                <td>{{ $order->domain_id }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ link_to_route('work_show_order_page', 'Выбрать', ['id' => $order->id]) }}</td>
                                {{--<td>{{ link_to_route('work_delete_order_action', 'Del', ['id' => $order->id]) }}</td>--}}
                                <td>
                                    {!! Form::open(['route' => 'work_delete_order_action', 'class' => 'form-signup']) !!}
                                    {!! Form::hidden('order_id', $order->id, []) !!}
                                    {!! Form::submit('Del', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
                <p></p>
                <div id="load_orders"></div>
                <div class="do_load">Do Load</div>
            @else
                Заказов сйечас нет
            @endif
        </div>
    </div>

    {!! Form::open(['route' => 'work_create_build_order_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('New Build Order', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

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
                            <th>type</th>
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
                                <td>{{ $order->acceptor_worker_id }}</td>
                                <td>{{ $order->type }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ link_to_route('work_show_order_page', 'Выбрать', ['id' => $order->id]) }}</td>
                                {{--<td>{{ link_to_route('work_delete_order_action', 'Del', ['id' => $order->id]) }}</td>--}}
                                <td>
                                    {!! Form::open(['route' => 'work_delete_order_action', 'class' => 'form-signup']) !!}
                                    {!! Form::hidden('order_id', $order->id, []) !!}
                                    {!! Form::submit('Del', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
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





{{--
    <div class="row text-center pad-top">

        @foreach ($workerOrders->chunk(2) as $chunk)
            <div class="row">
                @if ($chunk->count() == 2)
                    @foreach ($chunk as $order)
                        <div class="col-lg-6">
                            @include('_partials.individual_order_cmp', array('order' => $order))
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-6">
                        @include('_partials.individual_order_cmp', array('order' => $chunk->first()))
                    </div>
                    <div class="col-lg-6">
                    </div>
                @endif
            </div>
        @endforeach

    </div>
--}}




        {{--<div class="col-lg-6">--}}
            {{--<div class="panel panel-primary">--}}
                {{--<div class="panel-heading">--}}
                    {{--<h4>Сделать бассейн</h4>--}}
                {{--</div>--}}
                {{--<div class="panel-body">--}}

                    {{--<ul class="plan">--}}
                        {{--<li class="price"><strong>2500</strong> <i class="fa fa-dollar"></i></li>--}}
                        {{--<li><strong>52</strong> <strike>выкопать яму</strike></li>--}}
                        {{--<li><strong>50 GB</strong> обложить плиткой</li>--}}
                        {{--<li><strong>Free</strong> поставить трамплин</li>--}}
                        {{--<li><strong>Free</strong> обложить плиткой подходы</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="panel-footer">--}}
                    {{--<a href="#" class="btn btn-primary ">BUY NOW</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

@endsection

@section('right_column')


    {!! Form::open(['route' => 'generate_work_order_action', 'class' => 'form-signup']) !!}
    {!! Form::submit('Сгенерить заказ', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

    <p></p>
    @parent

@endsection

@section('scripts')

{{--    <script language="JavaScript">


        $(document).ready(function() {
            $(".do_load").click(function () {
                console.log('click');
                $.get( "http://adv/work/orders/ajax/1", function( data ) {

//                    var source   = document.getElementById('entry-template').innerHTML;
                    var source   = document.getElementById('orders-template').innerHTML;
                    var template = Handlebars.compile(source);

                    var html    = template(data.orders);

                    document.getElementById('load_orders').innerHTML = html;
                });
            });

        });

    </script>--}}
@endsection