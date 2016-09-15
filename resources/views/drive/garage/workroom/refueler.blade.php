
@if ($refueler == null)

    "Заправщик" прокачан до макс. уровня

@elseif ($refueler->level != 0)

    "Заправщик" улучшен до {{ $refueler->level }} уровня

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_upgrade_refueler_action', 'class' => '']) !!}
    {!! Form::submit('Улучшить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}


    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_refuel_action', 'class' => '']) !!}
    {!! Form::submit('Заправиться -> 10 л.', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
    <p></p>


@else {{--($refueler->level == 0)--}}

    Чтобы заправлять тачку надо приобрести аппарат "Заправщик"

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_buy_refueler_action', 'class' => '']) !!}
    {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endif
