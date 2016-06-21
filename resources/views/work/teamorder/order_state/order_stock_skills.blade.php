@extends('work.teamorder.show_order')


@section('stock_skills')

    <div class="row row-offcanvas">
        <div class="col-lg-8 col-sm-8">
            Для завершения\выполнения работ нужно проявить свои способности\навыки:
            <p></p>
            @if ($orderSkills != null)
                <ul>
                    <li>Навык \ Надо применить раз \ Применено раз</li>
                    @foreach($orderSkills as $orderSkill)
                        <li>{{ $orderSkill->code . " - "  .$orderSkill->need_times . " - " . $orderSkill->stock_times}}</li>
                        @if ($orderSkill->need_times > $orderSkill->stock_times)
                            {!! Form::open(['route' => 'work_teamorder_add_skill_in_stock_action', 'class' => 'form-signup']) !!}
                            {!! Form::hidden('skill', $orderSkill->code, []) !!}
                            {!! Form::hidden('order_id', $order->id, []) !!}
                            {!! Form::submit('Работать ' . $orderSkill->code, array('class' => 'btn btn-primary')) !!}
                            {!! Form::close() !!}
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="col-lg-4 col-sm-4">
            Ваши навыки
            <p></p>
            @if ($userSkills != null)
                <ul>
                    <li>Навык \ Уровень владения</li>
                    @foreach($userSkills as $userSkill)
                        <li>{{ $userSkill->code ." - ". $userSkill->value }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>


@endsection