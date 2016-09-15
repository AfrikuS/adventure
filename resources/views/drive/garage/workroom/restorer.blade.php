
@if ($restorer == null)

    "Спасатель" прокачан до макс. уровня

@elseif ($restorer->level != 0)

    "Спасатель" улучшен до {{ $restorer->level }} уровня

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'hero_oildistillator_upgrade_action', 'class' => '']) !!}
    {!! Form::submit('Улучшить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@else

    Чтобы восстанавливать тачку после тяжких и особо тяжких поверждений нужен аппарат "Спасатель"

    <p></p>
    <p></p>
    {!! Form::open(['route' => 'hero_oildistillator_buy_action', 'class' => '']) !!}
    {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

@endif
