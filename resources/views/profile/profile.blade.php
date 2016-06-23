@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('center')

Страница профиля\базы\штаба\ со всеми вещами\оборудованием
    <p>
        Каталог строй-скиллов
        @if (count($skills) > 0)
            <ul>
                <li>Скилл_Код \ Скилл_Title</li>
                @foreach($skills as $skill)
                    <li>{{ $skill->code . " - "  .$skill->value }}</li>
                @endforeach
            </ul>
        @endif

    <p></p>
    {{ link_to_route('profile_channels_page', 'Ресурсные каналы')  }}


@endsection

