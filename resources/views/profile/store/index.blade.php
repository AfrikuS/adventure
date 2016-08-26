@extends('profile._layout')

@section('title', 'Profile - Resource Store')
@section('head')
    @parent
@endsection

@section('center')

    <div class="row row-offcanvas">

        <div class="col-lg-4">

            <b>Oil Store (Нефтяное хранилище):</b>
            <p></p>
            <p></p>

            Уровень (1-7):  <b>{{ $oilStore->level }}</b> ур.
            <p></p>
            <p></p>
            Вместимость: <b>{{ $oilStore->amount }} / {{ $oilStore->capacity }}</b> галлонов.
            <p></p>

        </div>

        <div class="col-lg-4">

            <b>Petrol Store (Топливное хранилище):</b>
            <p></p>
            <p></p>

            Уровень (1-7):  <b>{{ $petrolStore->level }}</b> ур.
            <p></p>
            <p></p>
            Вместимость: <b>{{ $petrolStore->amount }} / {{ $petrolStore->capacity }}</b> литров.
            <p></p>

        </div>




        <div class="col-lg-4">

            <b>Water Store (Запасы воды):</b>
            <p></p>
            <p></p>

            Уровень (1-7):  <b>{{ $waterStore->level }}</b> ур.
            <p></p>
            <p></p>
            Ёмкость: <b>{{ $waterStore->amount }} / {{ $waterStore->capacity }}</b> капель.
            <p></p>

        </div>
    </div>


    <div class="row row-offcanvas">

        <div class="col-lg-4">
            @if ($oilStoreNext != null)

                <p></p>
                {!! Form::open(['route' => 'hero_oil_store_upgrade_action', 'class' => '']) !!}
                {!! Form::submit('Прокачать oil-store', array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                <p></p>
                <p></p>
                Будет
                <p></p>

                Уровень: <b>{{ $oilStoreNext->level }}</b> ур.
                <p></p>
                <p></p>
                Вместимость: <b>{{ $oilStoreNext->capacity }}</b> галлонов.
                <p></p>
                <p></p>
            @else

                <h4>Oil-Store Прокачан до макс. уровня</h4>

            @endif
        </div>

        <div class="col-lg-4">
            @if ($petrolStoreNext != null)

                <p></p>
                {!! Form::open(['route' => 'hero_petrol_store_upgrade_action', 'class' => '']) !!}
                {!! Form::submit('Прокачать petrol-store', array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                <p></p>
                <p></p>
                Будет
                <p></p>

                Уровень: <b>{{ $petrolStoreNext->level }}</b> ур.
                <p></p>
                <p></p>
                Вместимость: <b>{{ $petrolStoreNext->capacity }}</b> литров.
                <p></p>
                <p></p>
            @else

                <h4>Petrol-Store Прокачан до макс. уровня</h4>

            @endif
        </div>

        <div class="col-lg-4">

            @if ($waterStoreNext != null)

                <p></p>
                {!! Form::open(['route' => 'hero_water_store_upgrade_action', 'class' => '']) !!}
                {!! Form::submit('Прокачать water-store', array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                <p></p>
                <p></p>
                Будет
                <p></p>

                Уровень: <b>{{ $waterStoreNext->level }}</b> ур.
                <p></p>
                <p></p>
                Ёмкость: <b>{{ $waterStoreNext->capacity }}</b> капель.
                <p></p>
                <p></p>
            @else

                <h4>Water-Store Прокачан до макс. уровня</h4>

            @endif

        </div>

    </div>


    <div class="row row-offcanvas">

        <div class="col-lg-6">

            @include('profile.store.pump_oil', array('pumpOil' => $pumpOil))

        </div>

        <div class="col-lg-6">

            @include('profile.store.oil_distillator', array('oilDistillator' => $oilDistillator))

        </div>


    </div>
@endsection