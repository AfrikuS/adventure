@extends('layouts.app')


@section('left_column')

    @include('_partials.drive.left_menu')

@endsection


@section('right_column')

    @parent


    @include('_partials.drive.vehicle')


@endsection
