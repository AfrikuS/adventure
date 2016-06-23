@extends('work.teamorder.show_order')


@section('stock_materials')

    <div class="row row-offcanvas">
        <div class="col-lg-8 col-sm-8">
            Материалы необходимые для начала работ
            <p></p>
            @if ($orderMaterials != null)
                <ul>
                    <li>Материал \ Сколько надо \ Сколько внесено</li>
                    @foreach($orderMaterials as $material)
                        <li>{{ $material->code . " - "  .$material->need . " - " . $material->stock}}</li>
                        @if ($material->need > $material->stock)
                            {!! Form::open(['route' => 'work_teamorder_add_material_in_stock_action', 'class' => 'form-signup']) !!}
                            {!! Form::hidden('material', $material->code, []) !!}
                            {!! Form::hidden('order_id', $order->id, []) !!}
                            {!! Form::submit('Внести ' . $material->code, array('class' => 'btn btn-primary')) !!}
                            {!! Form::close() !!}
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="col-lg-4 col-sm-4">
            Ваши материалы
            <p></p>
            @if ($userMaterials != null)
                <ul>
                    <li>Материал \ Количество</li>
                    @foreach($userMaterials as $material)
                        <li>{{ $material->code . " - "  .$material->value }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@endsection