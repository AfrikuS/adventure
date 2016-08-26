@extends('admin.admin_layout')

@section('title', 'Admin - NPC / Characters')
@section('head')
    @parent
@endsection

@section('center')


    <div class="row row-offcanvas">
        <div class="col-lg-6 col-sm-6">
            Добавить NPCharacter
            {!! Form::open(['route' => 'create_npc_character_action', 'class' => '']) !!}
            {!! Form::label('name_label', 'Material code', ['class' => '']) !!}
            <br>
            {!! Form::text('name', 'Проводник ') !!}
            <br>
            <br>
            <br>
            {!! Form::submit('Add character', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>

        <div class="col-lg-6 col-sm-6">
            Каталог NPC-персонажей
            @if (count($characters) > 0)
                <ul>
                    <li>ID \ NAME</li>
                    @foreach($characters as $character)
                        <li>{{ $character->id . " - "  .$character->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@endsection