@extends('layouts.app')

@section('center')
{{--<div class="container">--}}

    <h1>Islands <a href="{{ url('/islands/create') }}" class="btn btn-primary btn-xs" title="Add New Island"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> {{ trans('islands.title') }} </th><th> {{ trans('islands.date_time') }} </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($islands as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->title }}</td><td>{{ $item->date_time }}</td>
                    <td>
                        <a href="{{ url('/islands/' . $item->user_id) }}" class="btn btn-success btn-xs" title="View Island"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/islands/' . $item->user_id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Island"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/islands', $item->user_id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Island" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Island',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            )) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $islands->render() !!} </div>
    </div>

{{--</div>--}}
@endsection
