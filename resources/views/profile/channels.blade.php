@extends('layouts.app')

@section('title', 'Profile - Channels Page')
@section('head')
    @parent
@endsection

@section('center')

    @if(count($channels) > 0)
        Ресурсные каналы, ведущие ко мне (приток ресурсов)
        <p></p>
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>FROM user</th>
                    <th>channel-resource</th>
                    <th>tax-percent %</th>
                </tr>
                </thead>
                <tbody>
                @foreach($channels as $channel)
                    <tr>
                        <td>{{ $channel->id }}</td>
                        <td><b>{{ $channel->fromUser->name }}</b></td>
                        <td>{{ $channel->resource }}</td>
                        <td>{{ $channel->tax_percent }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        Ресурсных каналов нет
    @endif

    <p><p><p>

    @if(count($lossChannels) > 0)
        Ресурсные каналы, идущие от меня (отток)
        <p></p>
        <table class="table table-condensed">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>To user-ID</th>
                    <th>channel-resource</th>
                    <th>tax-percent %</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lossChannels as $channel)
                    <tr>
                        <td>{{ $channel->id }}</td>
                        <td><b>{{ $channel->toUser->name }}</b></td>
                        <td>{{ $channel->resource }}</td>
                        <td>{{ $channel->tax_percent }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </table>
    @else
        Ресурсных каналов на отток ресурсов нет
    @endif

@endsection

