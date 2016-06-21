@extends('layouts.root_layout')

@section('title', 'Auction Page')
@section('head')
    @parent
@endsection

@section('content')

    <div class="container">
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-12">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
            </div>
        </div>
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-9 col-sm-9">

                @if(count($lots) > 0)
                    Список лотов
                    <table class="table table-condensed">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>LOT ID</th>
                                <th>Title</th>
                                <th>Цена</th>
                                <th>Owner name</th>
                                <th>Время</th>
                                <th>Покупатель</th>
                                <th>Ставка</th>
                                <th>Покупка</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lots as $lot)
                                <tr>
                                    <td>{{ $lot->id }}</td>
                                    <td>{{ $lot->title }}</td>
                                    <td><div id="bidValue_{{ $lot->id }}">{{ $lot->bid }}</div></td>
                                    <td>{{ $lot->owner_user_name }}</td>
                                    <td><div class="timer" data-seconds-left={{ $lot->duration_seconds }}></div></td>
                                    <td><div id="bidAuthor_{{ $lot->id }}">{{ $lot->purchaser_user_name or 'Нет'}}</div></td>
                                    {{--<form action="/auction/stavka" method="POST">--}}
                                    {{--{!! Form::open(['id' => 'bid']) !!}--}}
                                    {{--<input type="hidden" id="lot_id" value="{{ $lot->id }}">--}}
                                    <td>
                                        <form id="bid" class="bid_form">
                                            {!! Form::hidden('lot_id', $lot->id, ['id' =>  '', 'class' => 'lot_id']) !!}

                                            {{--<input type="submit" id="doBid" value="Сделать ставку">--}}
                                            {!! Form::submit('Сделать ставку', array('id'=> '', 'class' => 'btn btn-primary', 'name' => 'bid_submit')) !!}
                                        </form>
                                    </td>

                                    <td>
                                        {!! Form::open(['action' => ['AuctionController@buy'], 'class' => '']) !!}
                                        {!! Form::hidden('lot_id', $lot->id, ['id' =>  '']) !!}
                                        {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        @else
                            Лотов нет
                        @endif
                    </table>

                    <div class="row row-offcanvas">
                        <div class="col-lg-8 col-sm-8">
                            <p><p><p>
                                Expired LOTS
                            <p>
                            @if(count($lots) > 0)
                                <ul>
                                    @foreach ($expiredLots as $lot)
                                        <li>{{  $lot->owner_id }} | {{ $lot->title }} | {{  $lot->bid }} | {{  $lot->date_time }}</li>
                                    @endforeach
                                </ul>
                            @endif


                        </div>

                        <div class="col-lg-4 col-sm-4">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            @if (count($thingsForSale) > 0)
                                {!! Form::open(['route' => 'auction_add_lot_action', 'class' => 'form-signup']) !!}
                                <h2 class="form-signup-heading">Введите данные лота</h2>
                                <div class="form-group">
                                    <label for="sel1">Выберете вещь, к-ую будете продавать:</label>
                                    {{--{!! Form::select('thing_id', $thingsForSale, ['id'=> 'sel1', 'class' => 'form-control']) !!}--}}

                                    <select class="form-control" id="sel1" name="thing_id">
                                        @foreach($thingsForSale as $thing)
                                            <option value="{{ $thing->id }}">{{ $thing->title }} <- {{ $thing->id }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label>Стартовая цена</label>
                                {!! Form::text('bid', '345', ['id' =>  'id_bid', 'placeholder' =>  'bid_value', 'class' => 'form-control', 'type' => 'number', 'autofocus', 'required']) !!}
                                <br>
                                {!! Form::submit('Создать лот', array('class' => 'btn btn-primary')) !!}
                                {!! Form::close() !!}
                            @else
                                У вас нет вещей на продажу
                            @endif

                        </div>
                    </div>

            </div>

            <div class="col-lg-3 col-sm-3">
                @include('component/things')
            </div>

        </div>


    </div>
@endsection

            
@section('scripts')
    <script type="text/javascript" src="http://localhost:3000/socket.io/socket.io.js"></script>

    <script type="text/javascript">
        var socket = io('http://localhost:3000');
        var bidValue = '';

        socket.on('connect', function () {
            // socket save user-info
            socket.emit('init user', {!! $userJson !!});
        });

        socket.on('priceUpdate', function(bidData){ // format {bid, purchaser, lot_id}
            $('#bidValue_' + bidData.lot_id).html(bidData.new_bid);
            $('#bidAuthor_' + bidData.lot_id).html(bidData.purchaser);
//            $('#doBid').attr("disabled", false);
            console.log(bidData);
        });


        $('.bid_form').submit(function() {
            console.log(this);

//            var lotId = $('#lot_id').val();
            var lotId = $(this).find(".lot_id").val();
            var bidData = {
                lotId: lotId
            };
            socket.emit('bid', bidData);
//            $(this).find("input[name=bid_submit]").attr("disabled", true);
//            $('#doBid').attr("disabled", true);
            // do bid_button is disable while not recieved from server

            return false;
        });

        socket.on('accept bid', function(message) {
            console.log(message);
//            $('#doBid').attr("disabled", true);
        });

        socket.on('info', function(message) {
            console.log(message);
        });

        socket.on('lotCompleted', function (data) {
//            $("#doBid").prop('disabled', true);
            $('#message').html(data.message);
        });

    </script>

@endsection


{{--@section('resources')--}}
{{--    {{ parent() }}--}}
{{--@endsection--}}



