@extends('macro.layout')

@section('title', 'Process Page')
@section('head')
    @parent
    <script src="{{ asset('js/bootstrap-slider.js') }}"></script>
@endsection

@section('center')
    Цель - оптимальное управление людскими ресурсами. От малых групп к большим

    @if(count($employments) > 0)
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>LOT ID</th>
                    <th>Человек занято</th>
                    <th>employment_code</th>
                    <th>timer</th>
                    <th>Покупка</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employments as $employment)
                    <tr>
                        <td>{{ $employment->id }}</td>
                        <td>{{ $employment->people_count }}</td>
                        <td>{{ $employment->kind }}</td>
                        <td><div class="timer" data-seconds-left={{ $employment->duration_seconds }}></div></td>
{{--                        <td>{{ link_to_route('sea_create_order_page', 'Выбрать', ['id' => $employment->id]) }}</td>--}}
                        <td>{{ link_to_route('sea_create_order_page', 'Выбрать', ['id' => $employment->id]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        Кораблей нет
    @endif


@endsection


@section('scripts')
@endsection