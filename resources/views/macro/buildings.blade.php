@extends('macro.layout')

@section('title', 'Macro - Buildings Page')
@section('head')
    @parent
@endsection

@section('center')

    @if(count($buildings) > 0)
        Незанятые постройки в вашем селении
        <p></p>
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Building ID</th>
                    <th>Человек занято</th>
                    <th>employment_code</th>
                    <th>Здание сдано под</th>
                    <th>Покупка</th>
                </tr>
                </thead>
                <tbody>
                @foreach($buildings as $building)
                    <tr>
                        <td>{{ $building->id }}</td>
                        <td>{{ $building->count }}</td>
                        <td>{{ $building->concrete->title }}</td>
                        <td>{{ $building->concrete_building_id }}</td>
                        <td>{{ link_to_route('macro_buildings_page', 'Выбрать', ['id' => $building->id]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        Незанятых Строений нет
    @endif

    <p></p>

    <p></p>
    {!! Form::open(['action' => ['Macro\BuildingController@equip'], 'class' => '']) !!}
    Оборудовать здание под:
    <p></p>
    <select class="form-control" id="" name="kind">
        <option value="smith">Под Кузницу</option>
        <option value="farm">Под ферму</option>
    </select>

    @if (count($freeBuildings) > 0)
    <b>Выберите здание из числа свободных</b>
    <p></p>
    <select class="form-control" id="" name="building_id">
        @foreach($freeBuildings as $building)
            <option value="{{ $building->id }}">{{ $building->id }}</option>
        @endforeach
    </select>
    @endif

    <p></p>
    <label>Название для ...</label>
    {!! Form::text('title', 'Кузница', ['id' =>  '', 'placeholder' =>  '', 'class' => 'form-control', 'type' => 'string', 'autofocus', 'required']) !!}

    <p></p>
    {!! Form::submit('Оборудовать', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}
    <p></p>
    <p></p>
    <ul>
        <li>Открыть ферму => увеличить доход еды</li>
        <li>Открыть лесопилку => увеличить доход дерева</li>
        <li>Построить лодки => уменьшить время на добычу рыбы (еды)</li>
        <li>Открыть кузницу => уменьшить время на добычу дерева, уменьшить время на постройку лодок</li>
    </ul>
    Открыть кузницу, к-ая скоратит время по добыче дерева?
    Оборудовать кузницу (купить??? оборудование, Отдельная страница, оборудование эволюционирует)

    <p></p>
    <p></p>
    <p></p>
    {!! Form::open(['action' => ['Macro\BuildingController@build'], 'class' => '']) !!}
    Построить здание под (60 ед. дерева, 70 ед. еды):
    <p></p>
    <p></p>

    <p></p>
    {!! Form::submit('Построить', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}

@endsection
