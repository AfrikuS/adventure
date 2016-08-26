@extends('admin.admin_layout')

@section('title', 'Admin - Work / Catalogs')
@section('head')
    @parent
@endsection

@section('center')


    <div class="row row-offcanvas">
        <div class="col-lg-6 col-sm-6">
            Добавить строй-материал
            {!! Form::open(['route' => 'create_work_material_action', 'class' => '']) !!}
            {!! Form::label('code_label', 'Material code', ['class' => '']) !!}
            <br>
            {!! Form::text('code', '') !!}
            <br>
            {!! Form::label('code_title', 'Material title', ['class' => '']) !!}
            <br>
            {!! Form::text('title', '') !!}
            <br><br>
            {!! Form::submit('Add material', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

        <div class="col-lg-6 col-sm-6">
            Каталог строй-материалов
            @if (count($materials) > 0)
                <ul>
                    <li>Материал_Код \ Материал_Title</li>
                    @foreach($materials as $material)
                        <li>{{ $material->code . " - "  .$material->title }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-6 col-sm-6">
            Добавить строй-скилл
            {!! Form::open(['route' => 'create_work_skill_action', 'class' => '']) !!}
            {!! Form::label('code_label', 'skill code', ['class' => '']) !!}
            <br>
            {!! Form::text('code', '') !!}
            <br>
            {!! Form::label('code_title', 'Skill title', ['class' => '']) !!}
            <br>
            {!! Form::text('title', '') !!}
            <br><br>
            {!! Form::submit('Add skill', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>

        <div class="col-lg-6 col-sm-6">
            Каталог строй-скиллов
            @if (count($skills) > 0)
                <ul>
                    <li>Скилл_Код \ Скилл_Title</li>
                    @foreach($skills as $skill)
                        <li>{{ $skill->code . " - "  .$skill->title }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>


    <div class="row row-offcanvas">
        <div class="col-lg-6 col-sm-6">
            Добавить строй-инструмент
            {!! Form::open(['route' => 'create_work_instrument_action', 'class' => '']) !!}
            {!! Form::label('code_label', 'Instrument code', ['class' => '']) !!}
            <br>
            {!! Form::text('code', '') !!}
            <br>
            {!! Form::label('code_title', 'Instrument title', ['class' => '']) !!}
            <br>
            {!! Form::text('title', '') !!}
            <br><br>
            {!! Form::submit('Add instrument', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

        <div class="col-lg-6 col-sm-6">
            Каталог строй-инструментов
            @if (count($instruments) > 0)
                <ul>
                    <li>Инструмент_Код \ Инструмент_Title</li>
                    @foreach($instruments as $instrument)
                        <li>{{ $instrument->code ." - ". $instrument->title }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@endsection