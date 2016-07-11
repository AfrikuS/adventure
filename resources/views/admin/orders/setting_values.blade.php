@extends('admin.orders.layout')

@section('title', 'Team-Order-Builder. 1. Select Requrements')
@section('head')
    @parent

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@endsection

@section('window')


    <div class="row row-offcanvas">
        <h4>Fill Data</h4>
        {!! Form::open(['route' => 'teamorder_draft_fill_action', 'class' => '']) !!}
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
            <br>{{ Form::label('kind_work_title', 'Доп. сведения') }}
{{--            <br>{{ Form::text('order[kind_work_title]', $draftOrder->kind_work_title, ['size' => 25]) }}--}}
            <p></p><p></p>

            {{--{!! Form::select('order[kind_work_title]',--}}
                {{--array('L' => 'Large', 'S' => 'Small'),--}}
                {{--'S',--}}
                {{--['class' => 'order_kind_work_title', 'size' => '5'])--}}
            {{--!!}--}}
            <select name="order[kind_work_title]" class="order_kind_work_title">
                @foreach($skills as $skill)
                    @if($skill->code == $draftOrder->kind_work_title)
                        <option value="{{ $skill->code }}" selected="selected">{{ $skill->title }}</option>
                    @else
                        <option value="{{ $skill->code }}">{{ $skill->title }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-lg-6">
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
            {!! Form::submit('Save values', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection


@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $(".order_kind_work_title").select2();
        });

    </script>

@endsection