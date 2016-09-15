
    @if ($oilDistillator == null)

        Нефте-дистиллятор прокачан до макс. уровня

    @elseif ($oilDistillator->level != 0)

        Нефте-дистиллятор прокачан до {{ $oilDistillator->level }} уровня

        <p></p>
        <p></p>
        {!! Form::open(['route' => 'hero_oildistillator_upgrade_action', 'class' => '']) !!}
        {!! Form::submit('Улучшить', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

    @else {{--($oilDistillator->level == 0)--}}

        Дистиллятор надо сперва приобрести

        <p></p>
        <p></p>
        {!! Form::open(['route' => 'hero_oildistillator_buy_action', 'class' => '']) !!}
        {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

    @endif


