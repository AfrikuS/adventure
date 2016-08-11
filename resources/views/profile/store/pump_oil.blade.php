

    @if ($pumpOil == null)

        Нефтенасос прокачан до макс. уровня

    @elseif ($pumpOil->level != 0)

        Нефтенасос прокачан до {{ $pumpOil->level }} уровня

        <p></p>
        <p></p>
        {!! Form::open(['route' => 'hero_pumpoil_upgrade_action', 'class' => '']) !!}
        {!! Form::submit('Улучшить', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}

    @else {{--($pumpOil->level == 0)--}}

        Нефтенасос надо сперва приобрести

        <p></p>
        <p></p>
        {!! Form::open(['route' => 'hero_pumpoil_buy_action', 'class' => '']) !!}
        {!! Form::submit('Купить', array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    @endif


