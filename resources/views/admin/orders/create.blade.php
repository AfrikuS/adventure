@extends('layouts.app')

@section('title', 'Orders-Constructor. Step_1 - Admin Page')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <h4>Cоздать team-order</h4>
        {!! Form::open(['route' => 'admin_teamorder_create_action', 'class' => '']) !!}
        <div class="col-lg-6">
            <h4>Выберите материалы</h4>

            @if (count($materials) > 0)
                <ul>
                    @foreach($materials as $material)
                        <li>
                            {{--                            {{ Form::text('materials[]', 8, ['size' => 5]) }}--}}
                            {{ Form::checkbox('materials[]', $material->id) }}
                            {{ Form::label('material_'.$material->code , $material->title) }}
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>

        <div class="col-lg-6">
            <h4>Выберите навыки</h4>

            @if (count($skills) > 0)
                <ul>
                    @foreach($skills as $skill)
                        <li>
                            {{--                            {{ Form::text('skill_'.$skill->code, 9, ['size' => 5]) }}--}}
                            {{ Form::checkbox('skills[]', $skill->id) }}
                            {{ Form::label('skill_'.$skill->code, $skill->title) }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
            <br>{{ Form::label('price', 'Цена') }}
            <br>{{ Form::text('price', 9, ['size' => 5]) }}
            <br>{{ Form::label('desc', 'Описание') }}
            <br>{{ Form::text('desc', 9, ['size' => 25]) }}
            <br>{{ Form::label('kind_work', 'Доп. сведения') }}
            <br>{{ Form::text('kind_work', 9, ['size' => 25]) }}
        </div>

        <div class="col-lg-6">
            <h4>Выберите строй-инструменты</h4>
            @if (count($instruments) > 0)
                <ul>
                    @foreach($instruments as $instrument)
                        <li>
                            {{ Form::checkbox('instruments[]', $instrument->id) }}
                            {{ Form::label('instrument_'.$instrument->code , $instrument->title) }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        {!! Form::submit('Create order', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>

@endsection
