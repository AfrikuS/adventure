@extends('layouts.app')

@section('content')
    {{--<div class="container">--}}
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Locations</div>

                    <div class="panel-body">
                        Список локаций
                        <p></p>
                        <ul>
                        @foreach ($locations as $location)
                            <li>
                                <a href="/geo/location/{{ $location->id }}"> -> {{ $location->title }}</a>
                            </li>
                        @endforeach
                        </ul>

                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    {{--</div>--}}
@endsection
