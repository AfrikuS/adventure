@extends('admin.admin_layout')

@section('center')

    <p>
    <ul class="list-inline">
        <li>{{ link_to_route('teamorder_draft_main_page', 'Draft Page', ['id' => $orderDraft->id]) }}</li>
        <li>{{ link_to_route('teamorder_draft_select_requires_page', 'Select Requres', ['id' => $orderDraft->id]) }}</li>
        <li>{{ link_to_route('teamorder_draft_setting_page', 'Setting Values', ['id' => $orderDraft->id]) }}</li>
    </ul>

    @yield('window')

@endsection



