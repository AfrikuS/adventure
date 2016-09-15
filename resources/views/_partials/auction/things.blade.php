@if(count($heroThings) > 0)
    <ul>Вещи:
        @foreach($heroThings as $thing)
            <li>{{ $thing->id }} :=> {{ $thing->title }} (<b>{{ $thing->status }}</b>)</li>
        @endforeach
    </ul>
@else
    Блок для вещей/ Вещей нет
@endif
