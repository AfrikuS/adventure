@extends('work.work_layout')

@section('title', 'Sea -> Travel Port')
@section('head')
    @parent
@endsection

@section('center')

    Список команд private-teams
    <p></p>
    <ul>
        <li>TEAMS</li>
        <li>{{ link_to_route('work_create_privateteam_page', 'Create Own Private Team') }}</li>
    </ul>


    @if(count($teams) > 0)
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Team ID</th>
                    {{--<th>creator_user_id</th>--}}
                    {{--<th>kind_work</th>--}}
                    <th>status</th>
                    {{--<th>partners</th>--}}
                    <th>show</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td>{{ $team->id }}</td>
                        {{--<td>{{ $team->leader->user->name }}</td>--}}
{{--                        <td>{{ $team->kind_work }}</td>--}}
                        <td>{{ $team->status }}</td>
{{--                        <td>{{ $team->partners->count() | 'no' }}</td>--}}
                        <td>{{ link_to_route('work_show_privateteam_page', 'Выбрать', ['id' => $team->id]) }}</td>
{{--                        <td>{{ link_to_route('work_delete_order_action', 'Del', ['id' => $team->id]) }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        Команд не найдено
    @endif
<p></p>


@endsection

@section('right_column')

    @parent

    {{--{!! Form::open(['route' => 'generate_work_order_action', 'class' => 'form-signup']) !!}--}}
    {{--{!! Form::submit('Сгенерить заказ', array('class' => 'btn btn-primary')) !!}--}}
    {{--{!! Form::close() !!}--}}

@endsection

