@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('left_column')
    <dl>
        <dt>Profile LINKS</dt>
        <dd><a href="/profile">Страница профиля</a></dd>
        <dd><a href="/profile/channels">Ресурсные каналы</a></dd>
    </dl>

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

@endsection

