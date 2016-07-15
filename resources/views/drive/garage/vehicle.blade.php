@extends('drive.garage.garage_layout')

@section('title', 'Drive - Garage Vehicle')

@section('center')

    Инфа по тачке
    <p>
    данные, состояние в %
    <p></p>

    <div class="row row-offcanvas">
        <div class="col-lg-12">
            <h4>Детали вашего авто</h4>
            <p></p>
            @if($vehicleDetails->count() > 0)

            <table class="table table-condensed">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Зап-часть</th>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vehicleDetails as $vehicleDetail)
                        <tr>
                            <td>{{ $vehicleDetail->kind->title }}</td>
                            <td>{{ $vehicleDetail->title }}</td>
                            <td>
                                {!! Form::open(['route' => 'drive_vehicle_unmount_detail_action', 'class' => '']) !!}
                                {!! Form::hidden('detail_id', $vehicleDetail->id) !!}
                                {!! Form::submit('Снять', array('class' => 'btn btn-primary')) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </table>
            @else
                Деталей нет
            @endif

        </div>
    </div>

        Ваши авто-детали
    <div class="row row-offcanvas">
        <div class="col-lg-7">

            @if($driverDetails->count() > 0)
                <table class="table table-condensed">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>kind</th>
                            <th>title</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($driverDetails as $driverDetail)
                            <tr>
                                <td>{{ $driverDetail->id }}</td>
                                <td>{{ $driverDetail->kind->title }}</td>
                                <td>{{ $driverDetail->title }}</td>
                                <td>
                                    {!! Form::open(['route' => 'drive_vehicle_mount_detail_action', 'class' => '']) !!}
                                    {!! Form::hidden('detail_id', $driverDetail->id) !!}
                                    {!! Form::submit('Mount', array('class' => 'btn btn-primary')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </table>
            @else
                Деталей нет
            @endif

        </div>
        <div class="col-lg-3">
        </div>
    </div>

@endsection