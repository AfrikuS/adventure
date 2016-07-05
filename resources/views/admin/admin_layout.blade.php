@extends('layouts.app')

@section('left_column')

    <dl>
        <dt>Admin LINKS</dt>
        <dd>{{ link_to_route('admin_orderdrafts_page', 'Orders Drafts') }}</dd>
        <dd>{{ link_to_route('admin_locations_page', 'Locations Editor') }}</dd>
    </dl>

@endsection


@section('right_column')
    @parent
@endsection
