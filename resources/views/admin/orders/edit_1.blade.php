@extends('admin.admin_layout')

@section('title', 'Orders-Constructor. Step_1 - Admin Page')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <h4>Cоздать team-order</h4>
        {!! Form::open(['route' => 'admin_edit_orderdraft_1_action', 'class' => '']) !!}
        {!! Form::hidden('draft_id', $orderDraft->id) !!}

        <div class="col-lg-6">
            <h4>Выберите материалы</h4>

            @if (count($materials) > 0)
                <ul>
                    @foreach($materials as $material)
                        <li>
                            {{ Form::checkbox('materials[]', $material->code, in_array($material->code, $orderMaterialsCodes)) }}
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
                            {{ Form::checkbox('skills[]', $skill->code, in_array($skill->code, $orderSkillsCodes)) }}
                            {{ Form::label('skill_'.$skill->code, $skill->title) }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
        </div>

        <div class="col-lg-6">
            <h4>Выберите строй-инструменты</h4>
            @if (count($instruments) > 0)
                <ul>
                    @foreach($instruments as $instrument)
                        <li>
                            {{ Form::checkbox('instruments[]', $instrument->code, in_array($instrument->code, $orderIstrumentsCodes)) }}
                            {{ Form::label('instrument_'.$instrument->code , $instrument->title) }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
            {!! Form::submit('Save and fill data', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-lg-6">
{{--            {{ link_to_route('admin_edit_orderdraft_2_page', 'Заполнить данными', ['id' => $orderDraft->id]) }}--}}
        </div>
    </div>

@endsection
