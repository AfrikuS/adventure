
@if ($lift == null)

    Стоит самый лучший "Подъемник"

@elseif ($lift->level != 0)

    "Подъемник" улучшен до {{ $lift->level }} уровня

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'hero_oildistillator_upgrade_action', 'class' => '']) !!}
    {!! Form::submit('Улучшить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@else {{--($lift->level == 0)--}}

    Чтобы поднимать тачку (работать с кузовом и двигателем) нужен "Подъемник"

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'hero_oildistillator_buy_action', 'class' => '']) !!}
    {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endif
