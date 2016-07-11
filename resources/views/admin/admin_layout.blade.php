@extends('layouts.app')

@section('left_column')

    <ul>
        <li>Admin LINKS</li>
        <li>{{ link_to_route('admin_orderdrafts_page', 'Orders Drafts') }}</li>
        <li>{{ link_to_route('admin_locations_page', 'Locations Editor') }}</li>
        <p></p>
        <li>{{ link_to_route('admin_module_drive_page', 'Drive-Module') }}</li>
        <li>{{ link_to_route('admin_module_work_page', 'Work-Module') }}</li>
    </ul>

@endsection


@section('right_column')
    @parent
@endsection
