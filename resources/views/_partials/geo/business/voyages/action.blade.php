<?php
use \App\Modules\Geo\Domain\Entities\Business\Voyage;

?>
    @if($voyage->status == Voyage::STATUS_READY)

        {!! Form::open(['route' => 'geo_voyage_sail_action', 'class' => '']) !!}
        {!! Form::hidden('voyage_id', $voyage->id) !!}
        {!! Form::submit('Just Плыть') !!}
        {!! Form::close() !!}

    @elseif($voyage->status == Voyage::STATUS_IN_SAIL)

        {!! Form::open(['route' => 'geo_voyage_moor_action', 'class' => '']) !!}
        {!! Form::hidden('voyage_id', $voyage->id) !!}
        {!! Form::submit('Just Причалить') !!}
        {!! Form::close() !!}

    @elseif($voyage->status == Voyage::STATUS_FINISHED)

        Вернуться \ Начать торговлю
    @else
        Unknown Status
    @endif
