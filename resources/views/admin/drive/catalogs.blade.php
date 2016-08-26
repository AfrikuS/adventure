@extends('admin.admin_layout')

@section('title', 'Admin - Drive / Catalogs')
@section('head')
    @parent

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@endsection


@section('center')

    Drive Catalogs
    <p></p>
    Колеса -
    Подвеска (связь между корпусом и колесами, в т.ч. у рельсовых), степнь жесткости от ж - к мяг
    Кузов- body
    Трансмиссия (совок-ть механизмов и деталей, в т.ч. сцепление, коробка, дифф-ал). соед-ет двигатель и ведущие колеса
    Двигатель
    Топливная система (бак, топливоприводы - трубки\шланги, насос)

    <div class="row row-offcanvas">
        <div class="col-lg-6 col-sm-6">
            Добавить авто-детали
            {!! Form::open(['route' => 'create_detail_kind_action', 'class' => '']) !!}
{{--            {!! Form::label('code_label', 'Title', ['class' => '']) !!}--}}
            <br>
            {{--{!! Form::text('code', '') !!}--}}
            <br>
            {!! Form::label('detail_kind_label', 'Detail-kind title', ['class' => '']) !!}
            <br>
            {!! Form::text('detail_kind', '') !!}
            <br><br>
            {!! Form::submit('Add detail-kind', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

        <div class="col-lg-6 col-sm-6">
            Каталог видов авто-деталей
            @if (count($detailKinds) > 0)
                <ul>
                    <li>Материал_Код \ Материал_Title</li>
                    @foreach($detailKinds as $kind)
                        <li>{{ $kind->id . " - "  .$kind->title }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <p></p>
    <p></p>

    <div class="row row-offcanvas">
        <div class="col-lg-6 col-sm-6">
            Добавить наименования деталей
            {!! Form::open(['route' => 'create_detail_title_action', 'class' => '']) !!}
            {!! Form::label('kind_label', 'Тип детали', ['class' => '']) !!}
            <br>
            <select name="kind_id" class="drive_detail_kind">
                @foreach($detailKinds as $kind)
                        <option value="{{ $kind->id }}">{{ $kind->title }}</option>
                @endforeach
            </select>
            <br>
            {!! Form::label('detail_title_label', 'Detail-title', ['class' => '']) !!}
            <br>
            {!! Form::text('title', '') !!}
            <br><br>
            {!! Form::submit('Add detail-title', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

        <div class="col-lg-6 col-sm-6">
            Каталог возможных авто-деталей
            @if (count($detailTitles) > 0)
                <ul>
                    <li>Деталь_Вид \ Деталь_Title</li>
                    @foreach($detailTitles as $title)
                        <li>{{ $title->kind_id . " - "  .$title->title }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>


@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $(".drive_detail_kind").select2();
        });

    </script>

@endsection