@extends('layouts.app')

@section('title', 'Orders-Constructor Fill data. Step_2 - Admin Page')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <h4>Fill Data</h4>
        {!! Form::open(['route' => 'admin_edit_orderdraft_2_action', 'class' => '']) !!}
        {!! Form::hidden('draft_id', $orderDraft->id) !!}

        <div class="col-lg-6">
            <h4>Materials</h4>

            @if (count($draftMaterials) > 0)
                <ul>
                    @foreach($draftMaterials as $material)
                        <li>
                            {{ Form::text('materials['.$material->code.']', $material->need, ['size' => 5]) }}
{{--                            {{ Form::checkbox('materials[]', $material->code, in_array($material->code, $orderMaterialsCodes)) }}--}}
                            {{ Form::label('material_'.$material->code , $material->code) }}
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>

        <div class="col-lg-6">
            <h4>Skills</h4>

            @if (count($draftSkills) > 0)
                <ul>
                    @foreach($draftSkills as $skill)
                        <li>
                            {{ Form::text('skills['.$skill->code.']', $skill->need_times, ['size' => 5]) }}
                            {{ Form::label('skill_'.$skill->code , $skill->code) }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
            <br>{{ Form::label('price', 'Цена') }}
            <br>{{ Form::text('order[price]', $draftOrder->price, ['size' => 5]) }}
            <br>{{ Form::label('desc', 'Описание') }}
            <br>{{ Form::text('order[desc]', $draftOrder->desc, ['size' => 25]) }}
            <br>{{ Form::label('kind_work', 'Доп. сведения') }}
            <br>{{ Form::text('order[kind_work]', $draftOrder->kind_work, ['size' => 25]) }}
        </div>

        <div class="col-lg-6">
            {!! Form::submit('Save values and publish', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
            {{ link_to_route('admin_edit_orderdraft_1_page', 'Return to select attribs', ['id' => $orderDraft->id]) }}
        </div>
    </div>


@endsection