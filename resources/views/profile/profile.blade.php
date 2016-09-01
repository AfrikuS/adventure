@extends('profile._layout')

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


            {{ link_to_route('employment_profile_page', 'Рабочие навыки') }}
            {{--@if (count($workSkills) > 0)--}}
                {{--<ul>--}}
                    {{--<li>Скилл_Код \ Скилл_Title</li>--}}
                    {{--@foreach($workSkills as $skill)--}}
                        {{--<li>{{ $skill->code . " - "  .$skill->value }}</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--@endif--}}


        </div>

        <div class="col-lg-4">
            Выполненных заказов: N
            <p></p>Выполненных заказов в составе команды private-team: N
            <p></p>Выполненных заказов в составе команды private-team как лидер группы: N
        </div>
    </div>

    <div class="row row-offcanvas">
        <div class="col-lg-4">
            {!! Form::open(['route' => 'drive_raid_search_victim_action', 'class' => '']) !!}
            {!! Form::submit('Вступить в ряды драйверов', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

