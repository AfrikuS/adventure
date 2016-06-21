@extends('macro.layout')

@section('title', 'Process Exchange Page')
@section('head')
    @parent
@endsection

@section('center')

Здесь можно обмениваться ресурсами
<p></p>

Список лотов
@if($goods)
    <table class="table table-condensed">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>GOOD ID</th>
                <th>res_Title</th>
                <th>res_count</th>
                <th>Owner name</th>
                <th>intent_res_Title</th>
                <th>intent_res_count</th>
                <th>Покупка</th>
            </tr>
            </thead>
            <tbody>
            @foreach($goods as $good)
                <tr>
                    <td>{{ $good->id }}</td>
                    <td>{{ $good->resource_title }}</td>
                    <td>{{ $good->resource_count }}</td>
                    <td>{{ $good->user_id }}</td>
                    <td>{{ $good->intent_resource_title }}</td>
                    <td>{{ $good->intent_resource_count }}</td>

                    <td>
                        {!! Form::open(['action' => ['Macro\ExchangeController@change'], 'class' => '']) !!}
                        {!! Form::hidden('good_id', $good->id, ['id' =>  '']) !!}
                        {!! Form::submit('Обменять', array('class' => 'btn btn-primary')) !!}
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
    <p></p>

    {!! Form::open(['action' => ['Macro\ExchangeController@offer'], 'class' => 'form-signup']) !!}
    <h2 class="form-signup-heading">Введите данные лота</h2>
        <div class="form-group">
            <label for="sel1">Что хотите обменять:</label>
            <select class="form-control" id="" name="resource_title">
                <option value="water">Вода</option>
                <option value="tree">Дерево</option>
                <option value="red_balls">Красные шары</option>
                <option value="food">Еда ?</option>
            </select>
            <label>Единиц ресурса</label>
            {!! Form::text('resource_count', '50', ['id' =>  '', 'placeholder' =>  '', 'class' => 'form-control', 'type' => 'number', 'autofocus', 'required']) !!}
            <p></p>
            <label for="sel1">На что хотите обменять:</label>
            <select class="form-control" id="" name="intent_resource_title">
                <option value="water">Вода</option>
                <option value="tree">Дерево</option>
                <option value="red_balls">Красные шары</option>
                <option value="food">Еда ?</option>
            </select>
            <label>Единиц ресурса</label>
            {!! Form::text('intent_resource_count', '50', ['id' =>  '', 'placeholder' =>  '', 'class' => 'form-control', 'type' => 'number', 'autofocus', 'required']) !!}
            {!! Form::submit('Выставить', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>

@endsection

