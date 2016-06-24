@extends('layouts.app')

@section('title', 'Travel Ship-Shop - Geo Travel Page')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">
        <h4>Выберите товары</h4>
        {!! Form::open(['route' => 'travelship_create_order_action', 'class' => '']) !!}
{{--        {!! Form::hidden('draft_id', $orderDraft->id) !!}--}}

        <div class="col-lg-6">
            <h4>Materials</h4>

            @if (count($materials) > 0)
                <ul>
                    @foreach($materials as $material)
                        <li>
                            {{ Form::text('materials['.$material->code.']', '', ['size' => 5]) }}
                            {{--                            {{ Form::checkbox('materials[]', $material->code, in_array($material->code, $orderMaterialsCodes)) }}--}}
                            {{ Form::label($material->code.'_price', $material->price) }}
                            {{ Form::label('code', $material->code) }}
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>

        <div class="col-lg-6">
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
        </div>

        <div class="col-lg-6">
            {!! Form::submit('Купить товары', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
            {{--{{ link_to_route('admin_edit_orderdraft_1_page', 'Return to select attribs', ['id' => $orderDraft->id]) }}--}}
        </div>
    </div>


@endsection