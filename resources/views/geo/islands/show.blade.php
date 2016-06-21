@extends('layouts.app')

@section('center')
<div class="container">

    <h1>Island {{ $island->user_id }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>ID.</th><td>{{ $island->user_id }}</td>
                </tr>
                <tr><th> {{ trans('islands.title') }} </th><td> {{ $island->title }} </td></tr><tr><th> {{ trans('islands.date_time') }} </th><td> {{ $island->date_time }} </td></tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
{{--                        {{ link_to_route('sea_create_order_page', 'Выбрать', []) }}--}}
                        <a href="{{ url('islands/' . $island->user_id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Island"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['islands', $island->user_id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Island',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
@endsection