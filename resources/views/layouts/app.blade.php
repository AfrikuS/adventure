@extends('layouts.root_layout')

@section('content')
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="row row-offcanvas row-offcanvas-right">
                <div class="col-lg-12">
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::pull('message') }}</p>
                    @if(Session::has('errors'))
                        @foreach(Session::pull('errors') as $message)
                            <p class="alert {{ Session::get('alert-class', 'alert-warning') }}">{{ $message }}</p>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-lg-2">

                <ul>
                    @forelse($npcOffers as $offer)
                        {{ link_to_route('npc_show_offer_page', $offer->task, ['id' => $offer->id])  }}
                    @empty
                        Нет NPC-offers
                    @endforelse
                </ul>

                <p></p>
                <ul>
                    @forelse($npcDeals as $deal)
                        {{ link_to_route('npc_show_offer_page', $deal->task, ['id' => $deal->id])  }}
                    @empty
                        Нет NPC-deals
                    @endforelse
                </ul>


                @yield('left_column')
            </div>

            <div class="col-lg-7">
                {!! Breadcrumbs::renderIfExists() !!}

                @yield('center')
            </div>

            <div class="col-lg-3">
                    <p>
                    Hero-ресурсы
                    <ul>
                        <li>Нефть: {{ $heroResources->oil }}</li>
                        <li>Золото: {{ $heroResources->gold}}</li>
                        <li>Вода: {{ $heroResources->water }}</li>
                    </ul>
                    <p>
                    <p>
                    {!! Form::open(['route' => 'npc_generate_offer_page', 'class' => '']) !!}
                    {!! Form::submit('Cгенерить npc-offer', array('class' => 'btn btn-success')) !!}
                    {!! Form::close() !!}
                    <p>
                    <p>
                    <p>
                    {{--{!! Form::open(['route' => 'npc_generate_offer_page', 'class' => '']) !!}--}}
                    {{--{!! Form::submit('Normalize user', array('class' => 'btn btn-warning')) !!}--}}
                    {{--{!! Form::close() !!}--}}
                    <p>
                @yield('right_column')
            </div>
        </div>
    </div>

@endsection

