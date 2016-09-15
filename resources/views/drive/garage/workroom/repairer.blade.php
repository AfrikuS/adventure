
@if ($repairer == null)

    "Починщик" прокачан до макс. уровня

@elseif ($repairer->level != 0)

    "Починщик" улучшен до {{ $repairer->level }} уровня

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_upgrade_repairer_action', 'class' => '']) !!}
    {!! Form::submit('Улучшить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

    <p></p>
    {!! Form::open(['route' => 'drive_workroom_repair_action', 'class' => '']) !!}
    {!! Form::submit('Починить на 10 %', array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}
    <p></p>


@else {{--($repairer->level == 0)--}}

    Чтобы ремонтировать тачку надо приобрести аппарат "Починщик"

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'drive_workroom_buy_repairer_action', 'class' => '']) !!}
    {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endif
