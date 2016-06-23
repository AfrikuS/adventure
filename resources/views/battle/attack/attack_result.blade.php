@extends('layouts.app')

@section('head')
        @parent

@endsection

@section('center')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Результат нападения</div>

                <div class="panel-body">

                    Бой между {{ $atacker->name }} и {{ $defenser->name }}
                    В результате нападения победил ХЗ
                    <p>
                    <a href="/search">Назад искать противня</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('right_column')
        @parent
@endsection
