@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('center')

    <p>Страница профиля\базы\штаба\ со всеми вещами\оборудованием
    <p>{{ link_to_route('profile_channels_page', 'Ресурсные каналы')  }}
    <p><p>

    <div class="row row-offcanvas">
        <div class="col-lg-4">
            Рабочие навыки
            @if (count($workSkills) > 0)
                <ul>
                    <li>Скилл_Код \ Скилл_Title</li>
                    @foreach($workSkills as $skill)
                        <li>{{ $skill->code . " - "  .$skill->value }}</li>
                    @endforeach
                </ul>
            @endif


        </div>

        <div class="col-lg-4">
            Выполненных заказов: N
            <p>Выполненных заказов в составе команды private-team: N
            <p>Выполненных заказов в составе команды private-team как лидер группы: N
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-4">
            Бойцовские достижения
        </div>
    </div>
@endsection

